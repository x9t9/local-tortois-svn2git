# local-tortois-svn2git-
A simple guide to migrate LOCAL svn repos made with tortoise to GIT .

## WHY ?? 

Because after spending hours on the net, trying to find answers, I couldn't find even one guide to help with **LOCAL** simple repos made with tortoise .
I also know that a lot of the less-advanced developers prefare GUI tools, and might not be comfortable with too much CLI ( although in this case - seems unavoidable ) . 


# Importing local ( tortoise ) repos to local GIT 
## TL;DR; ##
`D:\mig>svn2git svn://127.0.0.1/repo --username magic-MIDI --authors authors.txt
--notags --nobranches --notrunk`

Don't forget `authors.txt` ..
## TOOLS 
- **RUBY** ( win installer http://rubyinstaller.org/ ) 
- **SVN** ( I used tortouis )
- **svnserve.exe** as service
- **svn2git** as Ruby Gem https://rubygems.org/
- **GIT** command line toold 
- **.git** client

## Steps 

Inside brackets is versions and steps that I used for my machine configuration.

## 1 - Install above components :
 - ruby
Download the ruby installer for your machine from  http://rubyinstaller.org/ [  `win7 64 bit` ] 
Install using the `path` option in the installer ( **NOT** checked by default )
( `Add Ruby executables to your Path` )

- Ruby gem 
If you indeed used the path option in the installer - Just type `gem install svn2git` on CLI [ `CMDER` ]

- SVN 
-- **Client**
If you are reading this , than I assume you already have an SVN client, and even assume you already have tortoise . 

But it case I am wrong , and If you do not already have svn client , than install one of your choice [  The most basic ` Tortoise SVN` for win] https://sourceforge.net/projects/tortoisesvn/?source=typ_redirect
-- **Server**
you will need to install some kind of server to serve the SVN files .
I have used the simple `svnserve.exe` found inside the Tortoise install dir ( at `./bin`)
In order to install it as a service you will need to do :
`sc create svnserve binpath= "\"C:\Program Files\TortoiseSVN\bin\" --service -r D:\Repos" displayname= "Subversion Server" depend= Tcpip start= auto `
source : https://subversion.open.collab.net/articles/svnserve-service.htm
In reality, this command for me resulted in an error `~ access denied ` - and that was because of the path not being complete . the correct path should include the svnserve.exe part , to become like this :
`sc create svnserve binpath= "\"C:\Program Files\TortoiseSVN\bin\svnserve.exe" --service -r D:\Repos" displayname= "Subversion Server" depend= Tcpip start= auto `

In order to change it ( if you got it wrong for some reason ) - or delete the service when not needed -  just open `regedit` , and navigate to `HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\services\svnserve` or any other name you have given this service in the previous step. [`svnserve`] ( delete the whole key if you don't need it )

Now, if the command was ok, you still need to start the server , so either reboot machine, or go to the services [`My compuer-> Manage -> Services and Applications -> Services`] and again, search for service name ( 'Subversion Server' ) and start the service .

Another option is to downlaod `visualSVN server ` https://www.visualsvn.com/visualsvn/download/ and temporary install it . This option might be easier for it's visual GUI and easy config options.
- GIT 
Install any git of choice ,but make sure you have access to the command line tools with global path [ `CMDER`]
I had `sourcetree` installed on my machine, and also CMDR ( full version) that comes with GIT global.

## 2 - Conversion
### Preparation 

- You will need to know your SVN repos folder AND create an empty migration folder .
-- For ease of use , I just made a dir called `D://Repos/` on my machine, with all my `SVN` repos inside .
-- I had made anoter dir called `D://mig ` ( short for migration) to host any new `GIT` repos`

- Now , in CMDER ( or CMD , or any other CLI ) navigate to your ( empty ) designated folder [ `D://mig` ]
Create a file named authors.txt , with your authors map inside .
`svnUserName = gitUser < your_git_account_mail@mail.com >`  - one line for each user.
If you do not know the users , - you will need to use svn log ( see here : https://www.getdonedone.com/converting-5-year-old-repository-subversion-git/ ) 
where `svnUserName` is the SVN username and `gitUser` is your git user name

### Migration Execution
Now the buggy part began ( for me )

So now that everything is supposed to be ready, we can try to execute .

In your CLI of choice, type : 

`D:\mig>svn2git svn://127.0.0.1/repo --username svnUserName --authors authors.txt
--notags --nobranches --notrunk`

**Note**  : This is the final version that worked **FOR ME** . [  `--notags` , `--nobranches` ,  `--notrunk`]

As many threads on the net will reveal - it might not work well for your configuration of repositories.
It might has worked for me because I had no tags and branches ( had just empty folders ) ... so if you do have them, first try without  .

You could try some options in any combination , like : `--notags` , `--nobranches` ,  `--notrunk` and also `--rootistrunk`
@see https://github.com/nirvdrum/svn2git/issues/90 for some other problems and solutions other people encountered . 

*BTW* - this is why this repo is called ***Importing local ( tortoise ) repos to local GIT*** - It will work on LOCAL repositories , made with STANDARD Tortoise file structure without branches or tags . Maybe I should have called it  **Importing local ( *simple standard* tortoise ) repos to local GIT**..


Any time you will get an error , you might see a newly created `.git` file in your`D://mig` folder ( or whatever your empty migration folder is ) .
You will need to delete it before executing any further command , and be sure to delete it every time it fails . 
nother file you might see is a perl ( ?? ) dump file . It is not harmful - but delete it also .

Repeat as neeed .
### Post - Migration

So if the above process was ok, and you are here - this is the easy part .

Open `sourcetree ` ( or any of your git client ) and just clone the rep from `D://mig`
You should see all your history, files , authors etc,. 
( if you had branches ,or tags , you should also see those providing you did not used the `--nobranches` || `--notags` option. I would not know because I did not have them .

### resources :
https://subversion.open.collab.net/articles/svnserve-service.htm

http://jameskovacs.com/2007/06/12/installing-subversion-as-a-windows-service/

https://github.com/nirvdrum/svn2git/issues/90

https://www.getdonedone.com/converting-5-year-old-repository-subversion-git/

https://sourceforge.net/projects/tortoisesvn/
