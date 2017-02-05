package cmpe160.s20151.project3.test;

import java.util.ArrayList;
import java.util.Arrays;

import cmpe160.s20151.project3.BinarySearchTree;



/**
 * This is an example of a bad test design. 
 * I have put it here so that you check if your code works fine or not.
 * As you implement the project, run the following main method 
 * and fix errors if you have.
 * 
 * @author Cagatay Yildiz
 *
 */
public class BadTestExample {
	public static void main(String[] args) {
		// random numbers to create BinarySearchTree
		Integer [] arr = {4, 5, 3, 10, 6, 13, 7, 8, 9, 2, 15, 11, 1, 12, 14};
		
		ArrayList<Integer> list =  new ArrayList<Integer>(Arrays.asList(arr));
		
		//  
		// creating BinarySearchTree
		BinarySearchTree st = new BinarySearchTree();
		
		
		if(!st.isEmpty()) {
			System.out.println("Possibly error in isEmpty()");
		}

		
		for (int i : list) {
			st.insert(i);
		}
		
		//st.OrderTraversa(st.getRoot());
		
		
		
		if(!st.isBST()) {
			System.out.println("Possibly error in isBST()");
		}
		
		
		
		
		if (!st.contains(5)) {
			System.out.println("Possibly error in contains()");
		}
		
		if (st.height()!=6) {
			System.out.println("Possibly error in height()");
		}
		
		if (st.size()!=15) {
			System.out.println("Possibly error in size()");
		}

		st.delete(5);
		st.delete(8);
		
//		if (st.size()!=14) {
//			System.out.println("Possibly error in delete()");
//		}
		
		if (st.contains(5)) {
			System.out.println("Possibly error in contains()");
		}
		
		
	
		
		
		if (st.height()!=4) {
			System.out.println("Possibly error in height()");
		}
		
		st.delete(3);
		st.delete(7);
		//**************************************
		
		//System.out.println(st.spiralTraversal().toString());
		
		//st.inOrderTraversa(st.getRoot());
		//System.out.println(st.inOrderTraversal().toString());
		
		
		//********************************
		
		//st.printEachLevel();
		
		if (!st.spiralTraversal().toString().contentEquals("[4, 2, 10, 1, 6, 13, 9, 11, 15, 12, 14]")) {
			System.out.println("Possibly error in spiralTraversal()");
		}

		if (!st.inOrderTraversal().toString().contentEquals("[1, 2, 4, 6, 9, 10, 11, 12, 13, 14, 15]")) {
			System.out.println("Possibly error in inOrderTraversal()");
		}
		
		if (st.height()!=4) {
			System.out.println("Possibly error in height()");
		}
		
		st.insert(20);
		
		if (st.size()!=12) {
			System.out.println("Possibly error in insert()");
		}
		
		st.insert(8);
		st.insert(9);
		st.insert(18);

		
		
		if (!st.contains(18)) {
			System.out.println("Possibly error in contains() or insert()");
		}

		String s = "";
		for (int i = 1; i <= 15; i++) {
			for (int j = 1; j <= 20; j++) {
				if (st.areCousins(i, j)) {
					s += i + "-" + j + " ";
				}
			}
		}
		if (!s.contentEquals("1-6 1-13 6-1 8-12 8-14 8-20 9-11 9-15 11-9 12-8 12-14 12-20 13-1 14-8 14-12 15-9 ")) {
			System.out.println("Possibly error in areCousins()");
		}

		
		ArrayList<Integer> allNodes = st.spiralTraversal();
		for (Integer i : allNodes) {
			st.delete(i);
		}
		//st.printEachLevel();
	
	
		
		if(!st.isEmpty()) {
			System.out.println("Possibly error in isEmpty() or delete()");
		}
		
		
		
		
		
	}



}
