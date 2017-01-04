# local-tortois-svn2git - PHP script
A simple, primitive script to automate the migratiom of old SVN repos to GIT .

Go to the [root of this repo](https://github.com/x9t9/local-tortois-svn2git) to learn more .  

Or directly read it's [README.md](https://github.com/x9t9/local-tortois-svn2git)

## WHY ? 

Because manually doing this operation for 300 old svn repos seems a bit time consuming .


# Usage
## TL;DR; ##
Open the script . Read . Change local variables. Launch Browser. point to script . update browser. Wait for output. 

## Requierments 
For the script to run you will need all of the tools listed in the root folder [README.md](https://github.com/x9t9/local-tortois-svn2git) of this repo.

.. and of course a *amp stack or any otheer php server [ I used [xampp](https://www.apachefriends.org/index.html) ]


## Steps 

- Set up all the variables inside the script . they are pretty self - explanatory.

Optional variables are marked out by deafault.

- Launch browser and point to script .

The script will itterate all repos in a given root directory , create a new folder for each with repo name , generate a requiered `authors.txt` file, and start the migration .

## But not all my repos are in the same location ...
ahh .. next time try to be orgenized :-) 

Well, what I did in this situation was creating symlinks in one root directory that pointed to all the other HD / NET / Phisical locations where I had repos . It works .

## Support ?
None for now .
This was meant to be a one-timer to use one morning and forget . 

It has served it's purpose .

Now it is here on github only for future reference - or to maybe help someone else in this ( rare ) situation .

If anyone is interesting in contributing / changing / improve this script - be my guest .

## TODO 
- Verify faulty renaming functions
- Refractioning 

## Changelog
vr. 0.0.2 - Changed execution mode .
vr. 0.0.1 - Testing .
