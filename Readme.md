# Docker Shortcut Builder

## What Is This?

This is the result of moving most of my toolset to Docker. I grew tired of installing tons of software on my host 
operating system when I could just install and run them temporarily using Docker. This has greatly improved my ability
to get up and running quickly on a new machine. 

It has grown from being a few scripts to also including several server programs that I use on a regular basis. Now 
instead of just including functionality for development, it also can run everything my home server requires.

I have done my best to include support for Windows, MacOS and Linux, but I must confess that I do not use Windows
for much of anything outside gaming anymore so there may be some problems there (However if you're using this on
Windows, I suggest you run this in the WSL where it should work perfectly)

## How Do I Set This Up?

### Configuration File

Looking at `containers.json`, you will see the configuration for all the shell scripts that will be generated. 
I will document this in greater detail down the road. 

#### Scripts Support

By default some containers will assume that a scripts directory is available. In `containers.json`, you may set 
buildOptions.addScripts to false to disable this functionality. By default we assume that you will symlink the 
scripts directory to your home directory named `docker_scripts`

### Services

The `services/` directory contains several directories for different services and versions that have been configured.
Just go into the one you would like to launch, copy the `.env.example` file to `.env` if applicable and set your values.
From there you just run the `docker-compose` command and you're ready to go.

## Can I Contribute or Request Something New?

Absolutely! Submit a Ticket or Pull Request. I can't guarantee anything, I am open to improving this tool!