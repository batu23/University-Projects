/*
Student Name: Batuhan Demir
Student Number: 2013400159
Project Numbner: 5
Operating System: Virtual Machine
Compile Status: {Compiling}
Program Status: {Working}
Notes: In this project i've used topological sort algorithm which is done in 4. PS
*/

#include <iostream>
#include <fstream>
#include <vector>
#include <algorithm>
#include <cstddef>
#include <utility>
#include <iterator>
#include <stack>
#include <queue>

using namespace std;
//This constructor creates adlist which includes a pair whose first element is neighbor
//and second is its distance to its parent. To find the longest path, we first topologically
//sort the list and then hold distances in an array using dynamic programming.
class LongestPath {
	int num_cities, num_roads, start, end;

public:
	vector<vector<pair<int, int>>> cities;

#define vec vector<vector<pair<int, int>>> //to be practical

	vec read_input(char* inFile);
	void longest_path(vec &cities, char* outFile);
	void topological_sorting_by_DFS(vec &cities, vector<int> &tp);
	void DFS(vec &ad_list, vector<bool> &is_visited, int id, stack<int>& nodes_s);

	bool isReachable(vec &ad_list, int s, int d);

	LongestPath() :num_cities(0), cities() {}

};

//reads the given data and returns adlist
vec LongestPath::read_input(char* inFileName) {
	ifstream ifs(inFileName, ifstream::in);

	ifs >> num_cities;
	ifs >> num_roads;
	ifs >> start;
	ifs >> end;

	vec ad_list(num_cities + 1);

	for (int i = 0; i < num_roads; ++i) {
		int a, b, c;
		ifs >> a;
		ifs >> b;
		ifs >> c;
		ad_list.at(a).push_back(std::make_pair(b, c));
	}
	return ad_list;
}

//sorts topologically using DFS
void LongestPath::topological_sorting_by_DFS(vec &ad_list, vector<int> &tp) {
	vector<bool> is_visited(ad_list.size(), false);
	stack<int> s;

	for (unsigned i = 1; i<ad_list.size(); i++) {
		if (!is_visited[i]) {
			DFS(ad_list, is_visited, i, s);
		}
	}
	while (!s.empty()) {
		tp.push_back(s.top());
		s.pop();
	}
}

void LongestPath::DFS(vec &ad_list, vector<bool> &is_visited, int id, stack<int>& s) {
	is_visited.at(id) = true;
	for (pair<int, int> child : ad_list.at(id)) {
		if (!is_visited.at(child.first))
			DFS(ad_list, is_visited, child.first, s);
	}
	s.push(id);
}

//checks if given destination is reachable from given source
bool LongestPath::isReachable(vec &ad_list, int s, int d) {
	if (s == d)
		return true;

	vector<bool> visited(num_cities + 1);

	for (int i = 1; i <= num_cities; i++)
		visited[i] = false;

	queue<int> q;

	visited[s] = true;
	q.push(s);

	while (!q.empty())
	{
		s = q.front();
		q.pop();

		for (pair<int, int> p : ad_list.at(s)) {
			if (p.first == d)
				return true;

			if (!visited[p.first]) {
				visited[p.first] = true;
				q.push(p.first);
			}
		}
	}
	return false;
}

//stores the result in an array using dynamic programming
void LongestPath::longest_path(vec &ad_list, char* outFileName) {

	ofstream ofs(outFileName);
	vector<int> sorted;							//topological sorted cities
	topological_sorting_by_DFS(ad_list, sorted);
	vector<int> distance(num_roads, 0); 

	if (!isReachable(ad_list, start, end)) {
		ofs << "-1" << endl;
		return;
	}

	int start_pos = find(sorted.begin(), sorted.end(), start) - sorted.begin();
	int end_pos = find(sorted.begin(), sorted.end(), end) - sorted.begin();
	vector<int> start_to_end(sorted.begin() + start_pos, sorted.begin() + end_pos + 1);

	for (int i : start_to_end) {
		for (pair<int, int> p : ad_list.at(i))
			distance[p.first] = max(distance[p.first], distance[i] + p.second);
	}
	ofs << distance[end] << endl;
}

int main(int argc, char *argv[]) {

	if (argc != 3) {
		printf("Usage: ./project5 infile outfile\n");
		return 0;
	}

	LongestPath* lp = new LongestPath();
	lp->cities = lp->read_input(argv[1]);
	lp->longest_path(lp->cities, argv[2]);

	return 0;
}