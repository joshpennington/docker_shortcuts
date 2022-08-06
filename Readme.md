# Docker Shortcuts v2.0

## What Is This?

At its core, this is a script that creates many shell scripts for running specific Docker containers. It has a variety
of use cases, but I use this mostly to not have to install development tools on my host OS.

## Why Did You Make This?

This project is the result of me moving most of (if not all) my toolset to Docker. I avoid installing tools on my host
operating system when running them in Docker was possible. This has given me an incredible amount of flexibility with
how I can operte with respect to my job as a software developer.

In the past, I had supported PowerShell and Command Prompt on Windows, but with v2.0, I decided to not officially support
these shells at this time. I am not the best at scripting in those environments and Windows now has WSL so it does not 
feel super needed at this point. However, the configurable nature of this project means that someone could easily
contribte this to the project, should someone decide to.

## Setup

### Configuration

There are a few files to know about:

#### containers.json

This file contains the baseline configuration for the project. In most situations this file should be left alone and 
expanded / overwritten with containers.local.json

#### containers.local.json

This is a file that you should make in order to create the commands that you want to have available to you. Simply create
this file and set it up according to the specification below.

#### Specification

Here are the parts of the file and what their function is:

```jsonc
{
    "buildOptions": {
        // Some containers may assume that you have a scripts directory is available. Set to false if you wish to disable this functionality.
        "addScripts": true,
        // This is the location on your machine where you sill store your scripts
        "scriptsLocation": "~/docker_scripts"
    },
    "platforms": {
        // TBD: This is where you configure a specific platform to be used. This is pretty fragile at the moment so I don't really
        // recommend that anyone go on their own to build out their own platform
    },
    // Custom commands are pretty much what they sound like. They are commands that you want to build as part of this project. In my
    // case I usually tie these to specific maintainence tasks that I run while using Docker.
    "customCommands": [
        {
            // The name of the command that will be used on the command line
            "name": "dcleanup",
            // The actual command that will run
            "command": "docker image prune -af"    
        }
    ],
    // This is the fun part. This is where you configure all the containers you want to have created 
    "containersToBuild": [
    	{
            // This will be the command that you end up running on the command line (dnode in this example)
            "group": "node",
            // This is the name of the container to run (node in this example)
            "organization": "node",
            // Versions of the container to build. This will build (dnode, dnode15, dnode14, etc. "latest" will not be a version, so "dnode")
            "versions": ["latest", "15", "14", "13", "12", "11", "16", "17"],
            // Any custom network that the container should join
            "network": "dockernet",
            // Define your default port mappings here
            "ports": ["3000:3000"],
            // The default command to run inside the container
            "command": "bash"
        }
    ]
}
```

### Building

The script to build the configuration is called `build.php`. If you have PHP installed on your host OS, you can run this and it will build
all your Docker scripts. In keeping with not having anything installed on your host OS, here is the Docker command to run the build script
using Docker (from macOS):

`docker run --rm -w /local -v $(pwd):/local php:8.1 php build.php`

Note: You will likely need to give execute permission to your scripts. I generally achieve this by going into the `nix` directory and running 
`chmod a+x *`.

### Add To Path

Now that you've built your scripts and they can execute, add the `nix` directory to your path so that it is accessible everywhere on your
system. 

### Done

You're done! Happy Dockering!

## Services

The `services/` directory contains several directories for different services and versions that have been configured.
Just go into the one you would like to launch, copy the `.env.example` file to `.env` if applicable and set your values.
From there you just run the `docker-compose` command and you're ready to go.

## Can I Contribute or Request Something New?

Absolutely! Submit an Issue or Pull Request. I can't guarantee anything, I am open to improving this tool!
