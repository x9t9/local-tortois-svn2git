# local-tortois-svn2git - PHP script
A simple, primitive script to automate the migratiom of old SVN repos to GIT .

Got the root of this repo to learn more . https://github.com/x9t9/local-tortois-svn2git-

## WHY ?? 

Because manually doing this operation for 300 old svn repos seems a bit time consuming .


# Usage
## TL;DR; ##
Open thee script . Read. Change local variables. Launch Browser. point to script . update browser. Wait. 

## Requierments 
For the script to run you will need all of the tools listed in the root folder README.md of this repo.
.. and of course a *amp stack [ XAMPP for me ]


## Steps 

Set up all the variables inside the script . they are pretty explanatory.

Launch browser and point to script .

The script will itterate all repos in a given root directory , create a new folder for each with repo name , generate a requiered `authors.txt` file, and start the migration .

## But not all my repos are in the same location ...
ahh .. next time try to be orgenized :-) 

Well, what I did in this situation was creating symlinks in one root directory that pointed to all the other HD / NET / Phisical locations where I had repos . It works .

## Support ??
None for now .
This was meant to be a one-timer to use one morning and forget .

It is here on github only for future reference - or to maybe help someone else in this ( rare ) situation .

If anyone is interesting in contributing / changing / improve - be my guest .
