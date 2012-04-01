// Name: Alex Wardi
// File: proj9.c
// Date: 03/30/2012
// Logical Assistance: Google, Beginning Linux 4th Ed.

#include <unistd.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/types.h>
#include <sys/wait.h>

#define WHITE "\t  \n"
#define MAXARG 20
#define MAXSIZE 100
#define PROMPT "<myshell> "

void parse(char*, char **);

int main(int argc, char** argv)
{
	char cmd[MAXSIZE];
	char* arg[MAXARG];
	pid_t pid;

	do
	{
		printf("%s", PROMPT);
		fgets(cmd, MAXSIZE, stdin);
		pid = fork();
		if (pid == -1)
		{
			printf("%s\n", "Error while forking!");
			exit(1);
		}
		else if (pid == 0) // If it's a child process, do the parsing & execute command
		{
			parse(cmd, arg);
			execvp(cmd, arg);
		}
		else // If it's a parent, wait for all children to finish
		{
			int stat;
			wait(&stat);
		}
	}while(strncmp(cmd, "exit", strlen("exit")) != 0);

	exit(0);
}

void parse(char *cmd, char *argv[]) // Function Courtesy of Professor Su
{
	int i=0, ampFound = 0;
 	argv[i]=strtok(cmd, WHITE);
	i++;	
	while( i<MAXARG && (argv[i]=strtok(NULL, WHITE)) != NULL )
		i++;
}

/// OUTPUT ///
/*
alex@Skipper:~/cmpsci/474/lab9$ ./ashell
<myshell> echo hello world
hello world
<myshell> ls -l myshell proj9.c
-rwxrwxr-x 1 alex alex 14694 2012-03-29 20:45 myshell
-rwxrwxr-x 1 alex alex   862 2012-03-29 23:07 proj9.c
<myshell> chmod 0777 myshell proj9.c
<myshell> ls -l myshell proj9.c
-rwxrwxrwx 1 alex alex 14694 2012-03-29 20:45 myshell
-rwxrwxrwx 1 alex alex   862 2012-03-29 23:07 proj9.c
<myshell> touch txtfile
<myshell> ls txtfile
txtfile
<myshell> exit
alex@Skipper:~/cmpsci/474/lab9$
*/
