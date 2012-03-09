# Gittern
Making Git like music for PHP's ears.

Version 0.8-dev

## What is Gittern?
Gittern is a PHP library for reading from and writing to Git repositories. It doesn't depend on the ```git``` binary, it directly acccesses the repo files.

Gittern provides several interfaces for interacting with your Git repos. Firstly, there's a low level interface, where you manually create blobs, trees and commits. This can however become cumbersome very quickly. As such, there's also two different Gaufrette adapters included. 

The first one, ```GitternTreeishReadOnlyAdapter``` is pretty much what it sounds like. It's an adapter to which you supply a treeish, and from which you may read the files associated with the treeish.

The second one, ```GitternIndexAdapter``` allows you to read from and write to the Git index. The Git index is the staging area in which you stage new changes for a commit. Then, when you're ready, creating a commit from the index is quite simple. Just get the tree from the index, and use it to create your commit.

In addition to all of this functionality, Gittern is created with extensibility in mind. How Gittern reads data from the repository on disk is cleanly separated using the adapter pattern, so that if you have the need you could easily implement e.g. an adapter capable of maintaining multiple indexes, or Git object caching in something like MongoDB or Redis (in fact, if you don't care about accessing the repo from the git binary, you could just use this as a fast, distributed backend).

## How do I install Gittern?
Use Composer.

## How do I use Gittern?
To be written.

## Planned features
There are several planned features, which didn't make it in to version 0.8. 

* Subclassing Repository with a git binary dependent subclass to allow some advanced commands,
* Packfile creation (currently packfiles can only be read)
* Support for resolving lightweight tags
* Support for reading annotated tags