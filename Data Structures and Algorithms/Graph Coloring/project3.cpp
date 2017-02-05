/*
Student Name:Batuhan Demir
Student Number:2013400159
Project Numbner: 2
Operating System: Virtual Machine
Compile Status: {Compiling}
Program Status: {Working}
Notes: Anything you want to say about your code that will be helpful in the grading process.
*/
#include <cstddef>
#include <fstream>
#include <iostream>
#include <string>
#include <vector>
#include <algorithm>
#include <list>
#include <stack>
#include <iterator>

using namespace std;
/*
This is constructor the Graph. Inside this constructor node constructor there is also.
*/
class Graph {

	class Vertex {
	public:
		int index;
		vector<int> neighbors;
		string color;
		Vertex(int n, vector<int> nb) {
			index = n;
			neighbors = nb;
			color = "";
		}
		void setColor(string cl) {
			color = cl;
		}
	};

	int num_of_ver;
public:
	vector<string> colors{ "red", "blue", "green", "orange" };
	list<Vertex>* vertices;

	Graph() :num_of_ver(0), vertices(NULL)
	{}
	~Graph() {
		vertices->clear();
		delete[] vertices;
	}
	void readData(char* in);
	void coloring(char* out);

};

void Graph::readData(char* inFileName) {
	ifstream ifs(inFileName, ifstream::in);
	if (!ifs) {
		cerr << "Couldn't open the file" << inFileName << endl;
		return;
	}
	int a = 0;
	ifs >> a;
	num_of_ver = a;

	if (num_of_ver == 0) {
		cout << "ups" << endl;
		return;
	}

	vertices = new list<Vertex>();

	//get data from input and create vertices and adjancy list
	for (int i = 1; i <= num_of_ver; ++i) {
		vector<int> temp_neighbors;
		for (int j = 1; j <= num_of_ver; ++j) {
			int a = 0;
			ifs >> a;
			if (a == 1)
				temp_neighbors.push_back(j);
		}
		vertices->push_back(Vertex(i, temp_neighbors));
	}
}

void Graph::coloring(char* outFileName) {
	ofstream ofs(outFileName);
	if (!ofs) {
		cerr << "Couldn't write the file" << outFileName << endl;
		return;
	}
	//sort vertices according to their adjancies decreasingly
	vertices->sort([](const Vertex a, const Vertex b) {
		return a.neighbors.size() > b.neighbors.size();
	});

	string temp_col;
	int col_num = 0;
	 /*
	 Loop contains a while loop and a for inside. First take vertex with most adjancies and
	 color it. After take 2. vertex from sorted list and if their adjancies is not
	 same color, color it with same color with first step.
	 */
	for (auto it = vertices->begin(); it != vertices->end(); ++it) {
		if (it->color != "") {
			continue;
		}
		else {
			temp_col = colors[col_num];
			it->setColor(temp_col);

			/*
			auto it2 = it ;
			it2++;
			while(it2 != vertices->end()){
			 */
			for (auto it2 = next(it,1); it2 != vertices->end(); ++it2) { //advance to next vertex
			bool adj2_same_color(false);

				for (unsigned int i = 0; i < it2->neighbors.size(); i++) {	//look for its neighbors
					int k = it2->neighbors.at(i);
					auto temp_ngbr = find_if(vertices->begin(), vertices->end(),
										[k](const Vertex &v) -> bool { return v.index == k; });
					if (temp_ngbr->color != "" && temp_ngbr->color == temp_col) {
						adj2_same_color = true;
						break;
					}
				}

			if (!adj2_same_color && it2->color == "")	 //if neigbors don't have same color and ours is not colored then color
				it2->setColor(temp_col);
		}
			//if reaches end of colors,then the graph is not 4-coloruable
		if (temp_col == "orange") {
			ofs << "ups" << endl;
			return;
		}
		++col_num;
		}
	}
   //sort graph index increasingly then write out colors

	vertices->sort([](const Vertex a, const Vertex b) {
		return b.index > a.index;
	});


	for (auto it = vertices->begin(); it != vertices->end(); ++it) {
		ofs << it->color ;
	}
}

int main(int argc, char *argv[]) {

	if (argc != 3) {
		printf("Usage: ./project3 infile outfile\n");
		return 0;
	}

	Graph* gr = new Graph();
	gr->readData(argv[1]);
	cout << "DONE !!! " << endl;
	gr->coloring(argv[2]);
	return 0;
}
