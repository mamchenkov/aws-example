#!/bin/bash

# This script is a simple wrapper for the Amazon AWS
# command line client.  It simplifies the deployment
# and rollback of CloudFormation stacks from a given
# template.

COMMAND=$1
STACK=${2:-Example}
PROFILE=${3:-default}

TEMPLATE="$(realpath $(dirname $0)/../cloudformation/templates/vpc.yml)"

# Print out usage help message
function print_help {
	echo
	echo Usage: $0 COMMAND [STACK [PROFILE]]
	echo
	echo COMMAND is one of the following:
	echo - deploy   : Deploy a new stack
	echo - rollback : Remove existing stack
	echo - help     : Print out this help
	echo
	echo STACK is a name of the stack.  Default: Example
	echo
	echo PROFILE is a name of AWS credentials profile.  Default: default
	echo
}

# Perform the requested action
case "$COMMAND" in
	"deploy")
		echo Deploying stack "$STACK" with profile "$PROFILE" from template "$TEMPLATE"
		aws --profile "$PROFILE" cloudformation create-stack --stack-name "$STACK" --template-body "file://$TEMPLATE"
		;;
	"rollback")
		echo Rolling back stack "$STACK" with profile "$PROFILE"
		aws --profile "$PROFILE" cloudformation delete-stack --stack-name "$STACK"
		;;
	"help")
		print_help
		;;
	*)
		echo
		echo Unrecognized command: $COMMAND
		echo
		print_help
		exit 1
		;;
esac
