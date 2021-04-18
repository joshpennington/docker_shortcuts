# Docker Shortcut Builder

## What this is

I originally made this as a set of Docker containers for me to have as part of my toolset. I would find that 
I needed a tool of utility in a one off situation and I grew tired of installing them when I realistically
only needed it once or twice.

Docker provides an excellent solution to this, but memorizing long commands was either difficult to do or I would 
enter it incorrectly (usually forgetting -it or --rm). 

Originally I created these scripts as static files, but then I moved from Windows to macOS and I had to rewrite
them all. So I decided to make a config file to build all the containers I needed.

Some common uses for me have been:

* Importing / exporting a database from a version of MySQL that I did not readily have installed
* Running an `npm` version that is either older or newer that what I have installed
* Running running or compiling `python`
* Running a random version of `php` without having to install it.
* Get a quick, throwaway instance of Ubuntu or Kali for one of the utilities you are familiar with.
* .net Core versions are a giant pain to deal with when you install them.

## What this isn't

* Something that runs permanently or a setup for a production environment.
* A replacement for a `docker-compose` file