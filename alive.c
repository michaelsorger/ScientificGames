#include <stdio.h>
#include <stdlib.h>
#include <string.h>

/*Given a list of people with their birth and end years 
(all between 1900 and 2000), find the year with the 
most number of people alive.
Solve using a language of your choice and dataset of your own creation.
Submission
Please upload your code, dataset, and example of the program’s output to Bit Bucket or Github. 
Please include any graphs or charts created by your program. */

//Michael Sorger
//Answer Problem 1
//Language: C
//Data set -> array of type person
//tests? -> create a file, add a bunch of names/dates, parse it

//Struct element for my array data structure
typedef struct person{
	int birthYear;
	int deathYear;
	char* name;
}person;

void parse_line(char* line, person* people, int counter);

int main(int argc, char* argv[])
{ 
	int num_person = 100; //change how many people to generate
	printf("Amount of people to test = %d\n", num_person);
	person* people = malloc(sizeof(person) * num_person); //I'm not sure how many people would be a good number to test. I just figured 1000
	int* century = calloc(100, sizeof(int)); //malloc and zero out every value
	int counter = 0;
	
	FILE * fp;
    char * line = NULL;
    size_t len = 0;
    ssize_t read;

    char* file_name = argv[1]; //file_name as argument passed from terminal


    //generate a bunch of random names, birth/date rates with a bunch of random numbers
    fp = fopen (file_name, "w");

    int r;
    char ran_name[1];
    int ran_birth;
    int ran_death;
    srand(time(NULL));
    for(r = 0; r < num_person; r++)
    {
    	//2 random characters for each persons name. (i didn't want to type 1000+ things to a file)
    	char randomletter = 'A' + (random() % 26);
    	char randomletter2 = 'A' + (random() % 26);
    	ran_name[0] = randomletter;
    	ran_name[1] = randomletter2;

    	//random ints between 1900 and 1999 where death > birth
    	ran_birth = 1900 + rand() % 50;
    	ran_death = ran_birth + rand() % 50;

    	fprintf(fp, "%s %d %d \n", ran_name, ran_birth, ran_death);
    }

    
   	fclose(fp);

   	//now read from that file
    fp = fopen(argv[1], "r");
    if (fp == NULL)
        exit(EXIT_FAILURE);


    //read the file given into my array of people
    while ((read = getline(&line, &len, fp)) != -1) 
    {
        //parses each line into a struct
        parse_line(line, people, counter);
   		counter++;
    }


    //for each person, get the life range of each person, and add 1 each year that person is alive
    int people_count = counter;
    int i;
    for (i = 0; i < people_count; i++)
    {
    	int born = people[i].birthYear;
    	int died = people[i].deathYear;
    	int j;
    	for(j = born; j < died; j++)
    	{
    		century[j]++;
    	}
    }
    
    //just loop through the century array, find the value thats the greatest!
    int max = 0;
    int year = 1900;
    int k;
    for(k = 1900; k < 2000; k++)
    {
    	if(century[k] > num_person)
    			continue; //if the number is greater than the total population, must be an error
    	if(century[k] > max)
    	{
    		max = century[k];
    		year = k;
    	}
    }

    printf("max year has %d people and is year %d\n", max, year);

    //don't forget to close the file.
    fclose(fp);
    if (line)
        free(line);
    exit(EXIT_SUCCESS);

    free(people);
    free(century);

    return 0;
}


/*
Parses a line read from the file and stores name, birth date, and death date into a struct.
Arguments are line from the file
an array of persons to store the values of the struct
a counter to track where in the array to store the values
Returns true if the line is parsed okay, otherwise, returns false
*/
void parse_line(char* line, person* people, int counter)
{
	char* token;

	//parse name
	token = strtok(line, " ");
  	people[counter].name = malloc(strlen(token)+1);
  	strcpy(people[counter].name, token);

  	//then birth
  	token = strtok(NULL, " ");
  	people[counter].birthYear = atoi(token);

  	//then death
  	token = strtok(NULL, " ");
   	people[counter].deathYear = atoi(token);
}