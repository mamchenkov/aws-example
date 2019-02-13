Ansible
=======

This part of the project includes Ansible configuration mangement
setup, which automates the configuration of the web servers.

## Files

* `inventory/all` - list of all servers and groups (only localhost)
* `inventory/host_vars/localhost.yml` - configuration variables for localhost
* `roles/` - a variety of Ansible roles to assist with configuration
* `ansible.cfg` - basic runtime configuration for Ansible itself
* `base.yml` - the main Ansible playbook to configure servers

## Requirements

In order to utilize provided setup, you will only need Ansible installed.

This setup has been verified with:

* Ansible v2.4.2 on CentOS 7

## Usage

You can run the playbook with the following command:

```
ansible-playbook base.yml
```

## Result

Once the provided Ansible configuration is applied, you will have the following:

1. EPEL RPM repository installed and configured.
2. REMI RPM repository installed and configured.
3. Git installed and configured.
4. Apache web server installed, configured, and running on port 80.
5. PHP 7.1 installed and configured.
6. Web application cloned from GitHub to `/var/www/aws-example`
7. `/var/www/aws-example/app/.env` file created from a copy of `/var/www/aws-example/.env.example`.
8. `.env` file variables replaced with any provided values
9. `/var/www/html` folder removed and replaced with symlink to `/var/www/aws-example/app/webroot`.
