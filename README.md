# Theta Tau Website 2016

Welcome to the repo for the Theta Gamma Chapter of Theta Tau's Website. Theta Gamma is located in the University of Michigan. This website is intended to be a landing page for rush candidates to learn about our chapter and fraternity and for Members to conduct certain business functions.

## Current Webchairs:


* [Apoorva Gupta](http://www.apoorvagupta.com)
* Justin Parus
* Diego Holt
* Nathan Louie (also VR)

## Completed Features:


* Home Page About/History text
* Rush Page text
* Google calendar-backed Rush Agenda

## Planned Features: 


(Not in any particular order)

* Calendar that's backed by Google calendar
* Members page with "cards" for each member
* Tht-cities page (under login)
* Theta Gamma Family Tree page
* Photo Album Page
* Login page
* Member pages with full profiles/resume uploads
* Event creation pages
* Event sign-in pages
* Eboard management panel (Scribe forms, attendance, Treasurer expense recording, Vice Regent Committee management tools [email lists, performance & planning, ])
* Admin management & configuration editing panel
* Pledge progress panel
* Slack integration
* AND MORE...

Keep checking back for more updates! [Contact](tht-web.committee@umich.edu) the current Web Chairs directly for bug reports, feature requests, and other general info!

## Developer Instructions:

By: [Apoorva Gupta](mailto:gapoorva@umich.edu)

Thanks for offering to help develop and maintain the website! To start developing, you're going to need some setup. These instructions are going to assume almost no experience with Github and Software Development. As a result, it might get wordy, but it's important for future webchairs to know it. Feel free to skip over the parts you already know, and add more information to improve these instructions.

It's gonna be tough to do web development if you don't know how to code for Web environments. As a result, you probably want to learn the basics of HTML5, CSS3, and JS. Our code also uses PHP and MySQL which are good to know too. As we choose to add more functions, we may use yet other technologies which are also good to get a background in. [www.w3schools](http://www.w3schools.com) has some great tutorials for some of the most popular languages, and is where I started learning things.

Once you have an idea of how to code, (or while you're learning) do the following to get yourself set up:

### Getting Access:

0. I'm writing this assuming you have a Linux/Unix setup (Like OS X), since that's what I use. If you're a serious developer you'd use the same (lol jkjk). Windows 10 is supposed to have a Bash terminal pretty soon which would be pretty hype, but you could also use something like Cygwin, a disk partion with Linux, or a VM that runs Linux. Long story short, if you're using Windows you could run into some problems. If you refuse to adopt any of these options, you might be on your own. Defintely type up what you do for future reference.

1. Get added to the Web Slack by the Vice Regent (or just join?). The team will use the Slack to communicate important information to each other all in one place plus [insert Slack advertising pitch here]. The best part is the github integration which lets us all know whenever anyone does stuff with the repo.

2. Learn about Git. There are a bunch of places to do this. You can choose to use the CLI (terminal) version or a GUI. Briefly, Git is a version-control tool that lets you use "repositories" (repos), to save projects in a central place. Then, you can clone (recreate) those projects on your local machine and make edits. Once you're at a point where you've accomplished a piece of work you want to save, you can "commit" and "push", which will persist your local changes to the central "master" copy. Git allows multiple people to work on a Software project in a controlled way. Read a LOT more at www.github.com.

3. Get added as a contributor to this repo. The repo is public, which means anyone can find it and clone it, but you need to be contributer to actually push and merge request to the repo. Any current contributor should be able to add you, or ask Apoorva. (gapoorva@umich.edu)

4. Gain access to the server. 
  a. We are (currently) hosting at Siteground. "Hosting" means the service that physically stores a copy of your code. When people try to go to your website, the hosting service sends back this copy to the client browser. Talk to current webchairs about where the Siteground credentials are.
  b. Siteground uses ssh keys. `ssh` stands for "Secure Shell", and allows you to access other remote computers from your terminal - ssh keys use crypto to authenticate you. To generate your ssh keys, open up a terminal and type
  ```
  $ ssh-keygen -t rsa -C "yourname@umich.edu"
  ```
  c. This will generate your ssh keys under the `~/.ssh/` folder. You should be able to verify that `~/.ssh/id_rsa` and `~/.ssh/id_rsa.pub`. Although not required, you can also set up an ssh profile for Siteground. This just makes it super easy to run ssh and saves the options you run ssh with. Do this by creating a file called `config` under your `~/.ssh/` directory. Then add the following to the file: 
  ```
  Host tht
      HostName thetatauthetagamma.com
      Port 18765
      User thetatau
  ```
  This will add the name "tht" as profile. You can also add more profiles for other hosts you connect to frequently, like the CAEN servers.

  d. Next, you need to add the public key of the ssh key pair you generated to our Siteground account. To learn more about why, read about [Public Key Cryptography](https://en.wikipedia.org/wiki/Public-key_cryptography). Once you login to Siteground, go to `My Accounts` > `Go to cPanel` > `Advanced` > `SSH/Shell Access`. Under __Upload SSH Key__, paste the contents of your key at `~/.ssh/id_rsa.pub` (p.s. you can get a quick output of the by doing `cat ~/.ssh/id_rsa.pub`). Leave the I.P address blank. Then hit upload.

  e. To verify everything worked, you can run this command in the terminal:
  ```
  $ ssh tht
  ```
  or, if you didn't set up the profile under `~/.ssh/config`, run the following:
  ```
  $ ssh thetatau@thetatauthetagamma.com -p 18765
  ```
  You should be given a prompt from the server! Our code should be under the `/home/thetatau/public_html` folder.

  f. Now that you can ssh into the server, __DON'T__ change anything. The server is meant to be "pull only", which means that when we're ready to put some new code on the internet for everyone to see, we first push it to the repo, and pull down (`git pull`) to the server from the repo. This ensures that the server matches the repo and not someone's unfinished work. As a good rule of thumb, you should never have to push code from the server.

### Setting up the Environment:

5. Time to set up a local environment on your computer. The first step is to clone the repo. `cd` into a directory that you want to keep the repo. I'm gonna call this directory `your/directory` from now on.

  a. To clone the repo type
  ```
  $ git clone "https://github.com/gapoorva/thetatauwebsite16.git"
  ```
  this will create a folder called `thetatauwebsite16` in `/your/directory`. Type `cd thetatauwebsite16` to enter it.

  b. The repo should look something like the following:
  ```
  your/directory/
	  thetatauwebsite16/
		  css/
		  fonts/
		  images/
		  js/
		  php/
		  mysql/
		  python/
		  docs/
		  index.php
		  Vagrantfile
		  (other php & html files & readme)
		  dev/
			  css/
			  font/
			  images/
			  js/
			  php/
			  sh/
			  mysql/
			  python/
			  index.php
			  (other php & html files)
  ```
  Notice that the `dev/` folder replicates the code folders that are under the main directory. This is on purpose. The `dev` folder is where you should do all your development and make changes. There is a build script (currently being built) that will compress the code and consolidate files to make "production" ready code. This setup namespaces new changes to the site to make a poor man's "staging" environment. Visitors to the site won't see updates to the site unless the build script is run (or if they visit the `dev/` namespace).

  c. Another important file to note is the `Vagrantfile`. This is a configuration file for a program called Vagrant that lets us spin up a virtual machine on your local machine to start a server. The reason we'll need a server is because PHP files are really server-side script files that need to be interpreted by the PHP interpreter. 

  Virtual machines are what they sound like. They allocate a small bit of the resources on your computer to simulate a machine that you can control, but which thinks it's its own separate, physical entity. They're super convient because they protect your real machine from things going wrong (aka you). They are also good for simulating production environments on your local computer.

  Our Siteground has a real apache server, but in order to just test your code you'd have to push it to the server. Not only could someone accidently use your broken code, but this system doesn't work when you have multiple people developing on the repo and trying to test their version of the code. Therefore, we're going to set up a local VM that will run a LAMP stack (**L**inux, **A**pache, **M**sql, **P**HP).

6. In order to set up the VM & server, you'll first need to download [VirtualBox](https://www.virtualbox.org/wiki/Downloads) and [Vagrant](https://www.vagrantup.com/downloads.html). Go to their sites and download them if don't have them already. VirtualBox is a bit hefty, but I garauntee that you'll use it in your career at some point, so it's a useful download.

7. Now that you have those, you should be ready to spin up the VM. First you need to get a "box" which is an "image" (aka template) of a whole computer. It sounds like a lot but it's not really much. Vagrant can spin up many separate machines for you based off this one template. To get your first box, run this:
  ```
  $ cd /your/directory/thetatauwebsite16
  $ vagrant add box hashicorp/precise64
  ```
  This will add the Hashicorp (creator of Vagrant) base box. The `Vagrantfile` in our repo is all set up, so you can just run
  ```
  $ vagrant up
  ```
  To get the VM started. It will print a bunch of stuff and take a minute, but be patient and it will eventually set everything up. There may be a few errors, but you can safely ignore this output. Now if you type
  ```
  $ vagrant status
  ```
  It should show you the `default` machine is up and running. If you ever want to stop the VM (like when you don't need it) run:
  ```
  $ vagrant halt
  ```
  Which just halts the machine for you. To start it back up, just do `$ vagrant up` again.

  You can now get into your shiny new VM by ssh if you'd like. The password is just `vagrant`.
  ```
  $ vagrant ssh
  ```
  If you do something wrong, or something just doesn't feel right, you can always get out of your machine by typing `$ logout` like on a normal computer. If necessary, run
  ```
  $ vagrant destroy
  ```
  On your "host" (your actual computer) to completely destroy the VM. This lets you start over easily. you just need to run `$ vagrant up` to bring up another, fresh VM. If only getting real computers were this easy...

8. Details about what's going on Vagrant aren't terribly important, but for the curious mind, here's a brief explaination. For the non-curious, feel free to skip to #9. __These are *not* commands that you need to enter in the terminal. Just documentation for Vagrant configs.__

  The Vagrantfile has a few configurations that make it super easy to setup the server. The most important are the following:

  a. The box to read from. This config sets up which image to use to spin up the VM from. Notice this is exactly what we got a few steps ago.
  ```
  config.vm.box = "hashicorp/precise64"
  ```

  b. Port forwarding. This causes the ports on the guest machine to forwarded to the Host. In other words, servers that listen on ports in the guest machine (Apache) can be communicated with from the Host machine on `localhost`.
  ```
  config.vm.network "forwarded_port", guest: 80, host: 8080
  ```
  c. Folder Syncronization. This allows your host machine and the VM to share a directory on your Host. The VM will mirror this directory with your Host, which means when you make changes in the directory from either machine, both machines will reflect the change. This lets you continue to code on your host machine while your VM serves out of the same directory. Pretty cool huh? 

  Note the first argument is the host path relative the Vagrantfile (aka the root of the repo). The second argument is the path on the VM the host directory should map to. This is set to the `/var/www` folder which is what Apache serves out of. (aka the Apache on the VM will serve up your copy of the repo).
  ```
  config.vm.synced_folder ".", "/var/www"
  ```
  d. Shell Script Provisioning. This allows us to run a couple start up scripts when the VM is first started. In our case, since we're using the VM to run a LAMP stack, I wrote a short shell script: `dev/sh/vagrantInitLAMP.sh`. This just runs some `apt-get` commands to install Apache, MySQL and PHP on the VM. This way, you won't need to ssh to the machine and deal with configuring it - it'll work "out of the box". But that doesn't mean you can ssh in and change configs later.
  ```
  config.vm.provision "shell", path: "./dev/sh/vagrantInitLAMP.sh"
  ```

9. At this point, after cloning the repo, downloading VirtualBox and Vagrant, and running `vagrant add box hashicorp/precise64` and `vagrant up`, your VM and server should be operational. Going to `http://localhost:8080/dev/` should show you the development version of website as it exists on your local computer. Yay! You can make edits to your files, reload the page, and see the effects of your changes. 

### Understanding the Development Pipeline

Now that you have a working environment, time to cover how you're actually going to make changes to the code and bring your ideas to life. This needs to be structured so that any mistakes made are revertable and we take full advantage of version control and namespacing to ensure the end-user (our fraternity) doesn't experience problems.

10. In a fully set up environment, use the git CLI or GUI to make a new "branch" from `master`.

  A branch is like a whole copy of the repository at certain period of time. For example, if I made a branch from `master` called `my-branch` on August 1st, `my-branch` would be exactly the same as `master`. Then, as time goes on and changes are made to either copy, `my-branch` will be different from `master`. Eventually, we can "merge" `my-branch` into master, which basically consolidates all the changes and differences between both branches.

  Branches let you have a personal copy of the repo to make changes and updates. Then, once you feel like you have a completed feature, you can merge the branch along with any commits you made to it into the master branch. This lets multiple people work of a codebase without constantly running into each other.

11. Once you create the branch and switch to it, make your changes and test in your local environment. Remember to commit changes often so you save your work in a way that it is retrievable.

12. If all is well, run the build script as follows:
  ```
  # TODO: update README with directions for build script
  ```
  This will prepare your code for production and deploy it to the root namespace.

13. When you finish your feature, make a Merge (pull) request to master. Using the git CLI or GUI. Let someone else on the Web committee pull down your changes, take a look at them and approve the merge. 

  If you have merge conflicts, you (or the dedicated resolver on the committee) will have to manually resolve the conflicts. This usually happens only when you change a file that someone else also changed during the time you were working on your branch. For this reason, try to communicate and avoid changing the same files. Merge conflicts are more work than they're worth :(

14. When your work is successfully merged, you are ready to deploy to the server. SSH into the server using the instructions above in step 4. Then `cd` into `public_html/dev`.

14. Run `git pull` inside the `dev/` folder. This will pull down your changes stored in master.

15. Open up http://www.thetatauthetagamma.com/dev/ in your web browser to see the updated changes. Navigate to the page(s) you changed to confirm your feature works properly on the server.

  **NOTE: If something is wrong at this step, DON'T try to make fixes directly on the server. This will put the server ahead of the master branch. Instead, go back to your local machine, make another branch and try to figure out the problem there.**



### Help

If something doesn't make sense, ask a senior Web Committee member or a CS major in the fraternity. If all else fails, contact Apoorva (gapoorva@umich.edu) with questions.