#!/usr/bin/python3
"""
Created on Sun Dec 4 15:46:20 2016

@author: batuhan demir
            2013400159
"""
import platform
import os
import sys
import re
import glob
import boto3
import time
from datetime import datetime
from collections import deque

### Topological sort of given graph
def topsort(graph):
    in_degree = { u : 0 for u in graph }     # determine in-degree 
    for u in graph:                          # of each node
        for v in graph[u]:
            in_degree[v] += 1
 
    Q = deque()                 # collect nodes with zero in-degree
    for u in in_degree:
        if in_degree[u] == 0:
            Q.appendleft(u)
 
    L = []     # list for order of nodes
     
    while Q:                
        u = Q.pop()          # choose node of zero in-degree
        L.append(u)          # and 'remove' it from graph
        for v in graph[u]:
            in_degree[v] -= 1
            if in_degree[v] == 0:
                Q.appendleft(v)
 
    if len(L) == len(graph):
        return L
    else:                    # if there is a cycle,  
        return []            # then return an empty list

ec2 = boto3.resource("ec2")
verbose = False
if '-v' in sys.argv[1]:
    verbose = True
    workflowdir = sys.argv[2]
else:
    workflowdir = sys.argv[1]    
wdf = workflowdir + '/*.wdf'
wdf = glob.glob(wdf)[0]
f = open(wdf,'r')

workflows = {}      # workflow dictionary where keys are identifiers
                    # values are programs to be run
for line in f:
    line = line.rstrip()
    if "%%" in line:
        break
    keysWorks = line.split(":")
    key = keysWorks[0]
    work = keysWorks[1]
    work = work[1:]
    workflows[key] = work 

adjancy_list = {}  # represent identifiers as graph using 
                    # dictionary where keys are nodes, values are adjancy nodes
for line in f:
    line = line.rstrip()
    nodes = line.split("=>")
    nodefrom = nodes[0]
    nodefrom = nodefrom.split()[0]
    nodeto = nodes[1]
    nodeto = nodeto.split()[0]
    if not nodefrom in adjancy_list:
        adjancy_list[nodefrom] = [nodeto]
    else:
        adjancy_list[nodefrom].append(nodeto)
f.close()
#if identifiers is not given in second part of wdf file
#insert leaf nodes to graph
for flowkey in workflows.keys():
    if flowkey not in adjancy_list:
        adjancy_list[flowkey] = []      


order = topsort(adjancy_list)

execprogs = []
for task in order:          ### sort prgrams topologically
    execprogs.append(workflows[task])   ### and append to a list


## run programs on Amazon using bash script
str = "#!/bin/bash\n"
str += "cd "+ workflowdir+"\n"
for prog in execprogs:
    if re.search("^\w+.py",prog) != None : #if python command add "python"
        str += "./" + prog +"\n"
    else:
        str += prog +"\n"
# temporary bash file help running programs
ssh_bash = open('ssh_bash.sh','w')
ssh_bash.write(str)
ssh_bash.close()

if platform.system() == 'Windows': # this is necessary for unix compability
    os.system('dos2unix ssh_bash.sh')
    
# create instance using boto3 with key wdf.pem and security group wdf
response = ec2.create_instances(
            ImageId="YOUR_AMI_ID", 
            MinCount=1,
            MaxCount=1,
            KeyName="wdf",
            SecurityGroups=['wdf'],
            InstanceType='t2.micro')
if verbose:
    instance_create_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    print(">>>>>>>>>  INSTANCE CREATED : " + instance_create_time +"  <<<<<<<<<<")
ids = []
while 1:
    running = 0 
    time.sleep(60)
    instances = ec2.instances.filter(Filters=[{'Name':'instance-state-name',
                                                'Values':['running']}])
    for instance in instances:
        ids.append(instance.id)
        running = 1 
        instanceIP = instance.public_ip_address.replace('.','-')
        os.system('tar -czf ssh_workflow.tar.gz ./ssh_bash.sh ./'+workflowdir)## compress workflow directory
        os.system('scp -o StrictHostKeyChecking=no -i wdf.pem ssh_workflow.tar.gz ubuntu@ec2-'+instanceIP+'.us-west-2.compute.amazonaws.com:/home/ubuntu')## copy the tar file to amazon
        
        if verbose:
            workflow_transferto_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(">>>>>>>>>  WORKFLOW TRANSFERRED TO INSTANCE : " + workflow_transferto_time +"  <<<<<<<<<<")
        
        os.system('rm ssh_workflow.tar.gz')
        os.system('ssh -o StrictHostKeyChecking=no -i wdf.pem ubuntu@ec2-'+instanceIP+'.us-west-2.compute.amazonaws.com tar -xzf ssh_workflow.tar.gz')## extract the tar file
        
        if verbose:
            workflow_begin_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(">>>>>>>>>  WORKFLOW EXECUTION STARTED : " + workflow_begin_time +"  <<<<<<<<<<")
        os.system('ssh -o StrictHostKeyChecking=no -i wdf.pem ubuntu@ec2-'+instanceIP+'.us-west-2.compute.amazonaws.com "bash -s" < ./ssh_bash.sh ')## run programs on instance using bash script
        if verbose:
            workflow_end_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(">>>>>>>>>  WORKFLOW EXECUTION ENDED : " + workflow_end_time +"  <<<<<<<<<<")
        
        os.system('ssh -o StrictHostKeyChecking=no -i wdf.pem ubuntu@ec2-'+instanceIP+'.us-west-2.compute.amazonaws.com tar -czf ssh_workflow.tar.gz ./'+workflowdir)## compress result workflow dir
        os.system('mkdir temp')## make a temporay directory to copy workflowdir
        os.system('scp -o StrictHostKeyChecking=no -i wdf.pem ubuntu@ec2-'+instanceIP+'.us-west-2.compute.amazonaws.com:/home/ubuntu/ssh_workflow.tar.gz ./temp')## copy result workflow tar file from instance
        if verbose:
            workflow_transferfrom_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
            print(">>>>>>>>>  WORKFLOW IS DOWNLOADED FROM INSTANCE : " + workflow_transferfrom_time +"  <<<<<<<<<<")
        
        os.system('cd temp && tar -xzf ssh_workflow.tar.gz')
        os.system('cd temp && cp -R '+workflowdir+' ../')
        os.system('rm -rf temp')
        os.system('rm ssh_bash.sh')

    if running:
        break

time.sleep(5)

ec2.instances.filter(InstanceIds=ids).terminate()
if verbose:
    instance_terminate_time = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    print(">>>>>>>>>  INSTANCE IS TERMINATED : " + instance_terminate_time +"  <<<<<<<<<<")
