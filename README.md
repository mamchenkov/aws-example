AWS Example
===========

This repository is an example of the Amazon AWS infrastructure deployment.
The purpose of it is to illustrate a possible automation approach to solve
a given problem, not to provide the best/ideal/complete setup.

## Problem

Write a script to automate the following:

* Deployment of CentOS on EC2
* Deployment of PostgreSQL database on RDS
* Deployment of load balancing and contingency solution
* Configuration of  AWS session affinity for an e-commerce website.

Additionally:

* Provide a network diagram and any additional documentation to describe the
  setup.

## Solution

There are many different ways to solve the problem, each with its own set of
pros and cons.  Even with the chosen solution here, there are numerous ways
to improve the setup.  The current setup however is considered sufficient for
the illustrative purposes.

This repository consists of three parts.  It is helpful to think about each part
as a completely separate component, which can be in a standalone repository, or
even replaced by a completely different component.

The components are:

1. `app` - a very simple standalone PHP application.  [Read more](app/README.md)
2. `ansible` - Ansible configuration setup for a web server, which also deploys the
  web application on the the given web server after the configuration.  [Read more](ansible/README.md)
3. `aws` - Amazon CloudFormation setup to provision the cloud infrastructure.  [Read more](aws/README.md)

Each component is described in details in its own documentation.

## Quick Start

The whole example is easily deployable with a single command, provided you have all
the requirements:

```
./aws/bin/aws.sh deploy
```

Once the CloudFormation stack is created, servers configured, and the application deployed,
you can access the web application either via the load balancer, or directly via either one
of the two web servers.

## How it works

Here is a high level description of how this example works:

1. `./aws/bin/aws.sh` bash script calls the Amazon AWS command line client and provides the CloudFormation
  template for cloud infranstructure provisioning.
2. AWS CloudFormation creates the necessary infrastructure.
3. Once each of the web servers is provisioned, CloudFormation executes post-install commands, which pass
  control to Ansible.
4. Ansible configures each individual web server and deploys the web application on to it.
5. Once all is done, CloudFormation provides all the necessary information (like URLs) via stack Outputs.

