#include <stdlib.h>
#include <stdio.h>
#include <unistd.h>
#include <sys/types.h>
#include <signal.h>

static int intTimes = 0;
static int quitTimes = 0;
int lives = 4;

void tryKill(int sig)
{
	printf("\n");
	if (sig == SIGINT && intTimes < 2)
	{
		intTimes++;
		lives--;
	}

	if (sig == SIGQUIT && quitTimes < 2)
	{
		quitTimes++;
		lives--;
	}
}

void getMsg()
{
	int l = lives;
	switch(l)
	{
		case 4 :
			printf("%d lives: Still going strong!\n", lives);
			break;
		case 3 :
			printf("%d lives: Hit, still going!\n", lives);
			break;
		case 2 :
			printf("%d lives: Wounded, still going!\n", lives);
			break;
		case 1 :
			printf("%d life: Dying, still going!\n", lives);
			break;
		default :
			printf("%d lives: DEAD!\n", lives);
			exit(0);
	}
}

int main(int argc, char** argv)
{
	struct sigaction killer;
	killer.sa_handler = tryKill;
	sigemptyset(&killer.sa_mask);
	killer.sa_flags = 0;

	sigaction(SIGQUIT, &killer, 0);
	sigaction(SIGINT, &killer, 0);

	while(1)
	{
		getMsg();
		sleep(1);
	}
}
