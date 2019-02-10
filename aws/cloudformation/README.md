AWS CloudFormation
==================

AWS CloudFormation is a tool that provides a flexible, but
simple way to provision AWS infrastructure and resources.

## Requirements

In order to use this example, you'll need the following:

1. An Amazon AWS account with sufficient privileges to manage resources.
2. A command-line AWS client.

You can register for an Amazon AWS account, which provides Free Tier for
everything required to run this example.

Installing a command-line AWS client on your machine is as easy as
running (on Fedora/CentOS/Red Hat Linux):

```
dnf install awscli
```

## Setup

1. Login to the [AWS Console](https://aws.amazon.com/console/) with your credentials.
2. Navigate to [IAM -> Users](https://console.aws.amazon.com/iam/home?#/users).
3. Select your username.
4. Switch to [Security Credentials](https://console.aws.amazon.com/iam/home?#/users/leonid?section=security_credentials) tab.
5. Click on "Create access key" button.
6. Copy the generated access and security keys.
7. Run `aws configure` in the command-line.
8. Provide the generated access and security keys.

Now that your AWS command-line client is configured, you can start using this 
example.

## Usage

### Creating the stack

In order to create the stack, run the following command:

```
aws cloudformation create-stack --stack-name Test --template-body "$(cat templates/vpc.yml)"
```

You can see the progress and additional information by navigating to 
AWS CloudFormation service in your AWS console and selecting the approrpriate
stack.

### Removing the stack

In order to remove the created stack, run the following command:

```
aws cloudformation delete-stack --stack-name Test
```
