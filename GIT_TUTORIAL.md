# Git Tutorial

## Git vs Github: 

What's the difference?

Git is a tool (executable) that runs on a local machine of a developer. It offers a version control system. A way to use this (that no ones does cause it's kinda dumb) you could have a server, install git on it, and have your team SSH into it, using git to version control the development. An alternate way to use git is to have it run on each local computer, and then use a third-party hosting service (like Github) to store the files in the "cloud". Other services that do this hosting include Gitlab and SourceForge.

This makes Github just a service that builds off of Git and allows people to store their code in "the cloud". Fun fact: the same guy who made Linux also made Git!

## How to use Git with Github: 

I usually like to use a GUI interface that github provides to work with git so I don't have to remember all the git commands, but that is totally optional (but also I would recommend it). Here's a [link to download the GUI](https://desktop.github.com/).

If you were to choose to use the CLI anyway, this is what your workflow would typically look like:

### Set up a repo

```
$ cd your/repo/containing/directory/like/Code
$ git clone https://github.com/username/repo.git
```

(depending on the repo settings, you may have to login)
The repo will now be in `your/repo/containing/directory/like/Code/repo`

### Show the status of git

```
$ git status
```

This will show you the state of files on your computer, and if there are any un-staged files with changes in them. In git, files are "staged" by "adding" them to commit - this causes you to explicitly say that you want to put these files into a commit.

It will also show you "untracked" files, aka files that you have created but have not asked git to include in your repo yet. You will also need to "add" these files. Keep reading to see what I mean

```
<Assume we make some changes to files>

$ git add file1 file2 dir/
```

This will "add" these changed files and everything in the dir directory to our staged files.

### Commit

To actually make a commit, stage all the files you want, then run this:

```
$ git commit -m "Description of what you did here"
```

This will create a local commit file on your machine. No one else on you team will see this because only you have the copy of the commit. If you ran `$ git status` now, you should see something that says "you are 1 commit ahead of the branch" (of your hosting service like Github)

### Pushing Changes to the server

The next step is to push to server. You could make several commits locally and then push all of them at once, but a much more common pattern is to commit + push. (Yeah idk either why they didn't make it just automatically push after commit)

```
$ git push origin myBranchHere
```

(see below about branches)

This should automatically push everything out to the remote repo on the branch that you're using.

### Pull from the server

Let's say someone on the team pushes to a branch on the server (Github). You can then get on that branch on your machine, and "pull" down their changes which lets you get the new updates.

```
$ git pull
```

Note: If you changed files on your local machine, and then pull changes that someone else made to the same file, you enter what is known as a merge conflict. This means git has no automated way to keep both changes in the file since they may have happened in the same place, and a human is going to have to sit down and fix those conflicts. You can also get a merge conflict if you push to the server and someone pushed before you with changes to the same file. (aka 2 versions simultaneously exist). Merge conflicts are pretty nasty and are worth their own tutorial, so a good rule of thumb is just avoid them and communicate about who's working on what file.

## Branches

One of the most confusing, but also important things about Git are branches. Git uses the concept of branches to allow different versions of repo to exist at the same time. Read "Why Branches" below to understand why they are used.

Let's say we start a repo and add 20 files to it. We will first start on what's known as the "default" or __master__ branch. The `master` branch is usually considered the BASE branch of the code base. When someone wants to make a branch they do the following on their local machine:

```
$ git checkout -b my-new-branch
```

This creates a branch on you local machine only and causes you to switch to it. If you did `$ git branch now`, you should see `master` and `my-new-branch` with a star next to it, indicating that's the one you're on. Right now, the branch is private to you. Let's make sure the server knows about it too:
```
$ git push origin my-new-branch
```

Now the server (and the rest of your team) knows about this branch too. You can now make normal commits and pushes and they will all go to this branch and show up on the server as a separate branch.

All this time, master has been left untouched. Because we eventually want master to contain all the code, we will merge the branch when we're done with it. To merge:

```
$ git merge origin/master
```

This will cause master to have all the updates you made on the my-new-branch, along with any changes it had since you made my-new-branch, as long as there are no conflicts merging the two code bases. If you want to merge into a branch other than master, you can replace "master" with that branch.

If you were working on a branch B that was derived from a branch A, and A gets some new updates that you want on your branch B, run:

```
$ git fetch origin
```

Usually you'd only do this if you needed the updates on A to continue work on B. Finally, if you want to get rid of branch you don't need anymore (like when it's all nicely merged) just do:

```
$ git branch -d my-new-branch
```

Those were a lot of commands, and usually I don't bother with memorizing them. If you use the GUI, you won't have to and everything will be laid out in a nice interface. While __how__ to do something is much more intuitive in the GUI, __why__ you are doing something is hard to understand unless you get the basic ideas above. Try and play around with a fake repo if something is not making sense. Github offers unlimited public and private repos now!

## Using Pull Requests

Pull requests are a feature of __Github__, not Git. Their GUI interface makes this super easy to do from your local computer, and is another reason to use the GUI. However, if you don't want to use the GUI, there are a couple third-party scripts that will do this, but I don't know about how they work, so I'd have to research before writing directions for those. Finally you can always create a pull request on the Github website.

Pull request are designed to let your team know that you're done with a branch and that you'd like to merge your changes in your isolated branch into the official code base. Pull requests give your team a chance to look at the changes made on a branch by going to their local machine, and running the following:

```
$ git fetch orgin
$ git checkout -b candidate-branch origin/candidate-branch
```

This will move them onto the branch with your work where they can take a look at the code and verify it's not going to break anything. This is called a "code review" in industry. Your peers can sanity-check your code and confirm that it's best way to make the change. If needed, they can point issues which you can fix, commit, and re-push. Then on the Github website, they merge and close the branch. Now your code is in master and part of the offical codebase.

Directions for making a pull request from the Github website in case you refuse to use to GUI or CLI : [Making a Pull Request on Github](https://help.github.com/articles/creating-a-pull-request/)

Open source projects often use this workflow, because people who want to contribute just make branches, write their feature/bug fix, and then a group of moderators can code review the branch and merge it if they think it works.

## Why Branches

Using branches allows you to have a whole copy of the entire codebase and work on that separately, and then control the merges when you're done using a separate copy. Using branches, a typical work flow would look like this:

1. See that we need to add a feature to the code
2. Make branch that is dedicated to that feature
3. Work on said branch
4. Merge branch to master (or another branch) OR make a pull request.

In industry, software companies often create branches of their code for monthly/weekly releases. Because consumers of the software don't expect things to be constantly changing, they need a stable codebase, but the company needs a code base to constantly make edits on. So they make a release branch and give this consumers, while continuing to develop off of the master branch.