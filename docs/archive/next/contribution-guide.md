---
description: How to contribute to Athenaeum
sidebarDepth: 0
---

# Contribution Guide

Have you found a defect ( [bug or design flaw](https://en.wikipedia.org/wiki/Software_bug) ), or do you wish improvements? In the following sections, you might find some useful information
on how you can help this project. In any case, I thank you for taking the time to help me improve this project's deliverables and overall quality.

[[TOC]]

## Bug Report

If you have found a bug, please report it on [GitHub](https://github.com/aedart/athenaeum/issues/new/choose).
When reporting the bug, do consider the following:

* Where is the defect located
* A good, short and precise description of the defect (_Why is it a defect_)
* How to replicate the defect
* (_A possible solution for how to resolve the defect_)

When time permits it, I will review your issue and take action upon it.

## Security Vulnerability

Please read the [Security Policy](./security.md).

## Feature Request

If you have an idea for a new feature or perhaps changing an existing, feel free to create a [feature request](https://github.com/aedart/athenaeum/issues/new/choose).
Should you be unsure whether your idea is good (_or acceptable_), then perhaps you could start a [discussion](https://github.com/aedart/athenaeum/discussions).

## Code Style

On a general note, [PSR-12](https://www.php-fig.org/psr/psr-12/) is used as code style guide.

### PHPDoc

[PHPDoc](https://www.phpdoc.org/) us used to document source code, such as classes, interfaces, traits, methods...etc.
Please make sure that your contributed code is documented accordingly. 

### Easy Coding Standard

[Easy Coding Standard](https://github.com/symplify/easy-coding-standard) is configured in the project, which is automatically triggered on every push and pull request.
It ensures that [PSR-12](https://www.php-fig.org/psr/psr-12/) is upheld.
To execute it locally, run the following command:

```shell
composer run cs
```

## Fork, code and send pull-request

If you wish to fix a bug, add new feature, or perhaps change an existing, then please follow this guideline

* Fork this project
* Create a new local development branch for the given fix, addition or change
* Write your code / changes
* Create executable test-cases (_prove that your changes are solid!_)
* Commit and push your changes to your fork-repository
* Send a pull-request with your changes (_please check "Allow edits from maintainers"_)
* _Drink a [Beer](https://en.wikipedia.org/wiki/Beer) - you earned it_ :)

As soon as I receive the pull-request (_and have time for it_), I will review your changes and merge them into this project. If not, I will inform you why I choose not to.
