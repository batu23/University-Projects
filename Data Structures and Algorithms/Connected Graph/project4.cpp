/*
Student Name:Batuhan Demir
Student Number:2013400159
Project Numbner: 4
Operating System: Virtual Machine
Compile Status: {Compiling}
Program Status: {Working}
Notes: i expect full grade) 
*/
#include <cstddef>
#include <fstream>
#include <iostream>
#include <vector>
#include <algorithm>
#include <queue>
#include <iterator>

using namespace std;
/*
This constructor creates the city in adjancy list. Then in runBFS function
infects the neigbors. Then in runDFS function, counts how many connected
non-infected cities there are.
*/
class Byteotia {

	int num_cities;
	int num_roads;
	int num_infected_first;
	int days_passed;

public:
	vector<vector<int>> cities;	 //adjancy list
	bool infected[100001];		 //bool array of infected cities

	Byteotia() :num_cities(0), cities()
	{}

	vector<vector<int>> readData(char* in);
	void runBFS(vector<vector<int>> &adlist, vector<int> infected, int depth);
	void runDFS(int city, vector<vector<int>> &adlist);
	void quarantine(vector<vector<int>> &adlist, char* out);

};

//gets the data from given file and returns adlist
vector<vector<int>> Byteotia::readData(char* inFileName) {
	ifstream ifs(inFileName, ifstream::in);
	if (!ifs) {
		cerr << "Couldn't read the file" << inFileName << endl;
		return vector<vector<int>>();
	}

	for (int i = 0; i < 100001; ++i) 
		infected[i] = false;

	ifs >> num_cities;
	ifs >> num_roads;
	ifs >> num_infected_first;
	ifs >> days_passed;

	vector<vector<int>> adlist(num_cities + 1);

	for (int i = 0; i < num_roads; ++i) {
		int a, b;
		ifs >> a;
		ifs >> b;
		adlist.at(a).push_back(b);
		adlist.at(b).push_back(a);
	}

	vector<int> inf_first(num_infected_first);

	for (int i = 0; i < num_infected_first; ++i) {
		int a;
		ifs >> a;
		inf_first.push_back(a);	   
	}

	runBFS(adlist, inf_first, days_passed);

	return adlist;
}

//makes limited times breadth first search and infects others
void Byteotia::runBFS(vector<vector<int>> &cities, vector<int> inf_first, int days) { 

	queue<int> q;
	
	int num_curr_cities = 0; //current number of cities in queue
	int num_next_cities = 0; //number of cities will be in queue next step
							 //i.e. neighbors of popped City
	int curr_depth = 0;		//current depth of bfs


	bool inqueue[100001];

	for (int i = 0; i < 100001; ++i)
		inqueue[i] = false;

	for (int a : inf_first) {
		q.push(a);
		inqueue[a] = true;
		++num_curr_cities;
	}

	while (!q.empty()) {

		int tmp_city = q.front();
		q.pop();
		infected[tmp_city] = true;

		--num_curr_cities;
		
		int k = 0;

		for (int i : cities.at(tmp_city)) {
			if (!infected[i] && !inqueue[i]) {
				inqueue[i] = true;
				q.push(i);
				++k;
			}
		}
		num_next_cities += k;

		if (num_curr_cities == 0) {
			++curr_depth;
			if (curr_depth > days) {
				return;
			}
			num_curr_cities = num_next_cities;
			num_next_cities = 0;
		}
	}
}

void Byteotia::runDFS(int city, vector<vector<int>> &cities) {
	
	infected[city] = true;
	for (int i : cities.at(city)) {
		if (!infected[i])
			runDFS(i, cities);
	}

}

//counts not infected connected cities
void Byteotia::quarantine(vector<vector<int>> &cities, char* outFileName) {
	ofstream ofs(outFileName);
	if (!ofs) {
		cerr << "Couldn't write the file" << outFileName << endl;
		return;
	}

	int result = 0;

	for (int i = 1; i <= num_cities; ++i) {
		if (!infected[i]) {
			runDFS(i, cities);
			++result;
		}
	}
	
	ofs << result << endl;

}

int main(int argc, char *argv[]) {

	if (argc != 3) {
		printf("Usage: ./project4 infile outfile\n");
		return 0;
	}
	Byteotia* by = new Byteotia();
	by->cities = by->readData(argv[1]);
	by->quarantine(by->cities, argv[2]);

	return 0;
}