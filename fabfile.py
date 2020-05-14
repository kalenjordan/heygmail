from __future__ import with_statement
from fabric.api import *
from fabric.contrib.console import confirm
from fabric.colors import green
from fabric.operations import put

import datetime, sys

env.use_ssh_config = True
env.forward_agent = True
env.hosts = ['commercestack']
env.shell = "/bin/bash -l -i -c"

def printUsageAndExit():
	print 'Usage: fab command'
	print 'Example: fab deploy'
	sys.exit(0)

remoteDocumentRoot = '/home/forge/starter'
remoteSkinPath = remoteDocumentRoot + '/public'
remoteSkinPathAssets = remoteDocumentRoot + '/public/assets'

print(green("1. Starting deploy to starter"))

def deploy():
	with cd(remoteDocumentRoot):
		print(green("2. Checking out latest from Git"))
		run('git fetch')
		run('git checkout origin/master --quiet')

	with cd(remoteDocumentRoot):
		print(green("3. Running composer install"))
		run('composer install --no-dev')

	with cd(remoteDocumentRoot):
		print(green("4. Running npm"))
		run('npm install')

	with cd(remoteDocumentRoot):
		print(green("4. Running npm"))
		run('npm run prod')

