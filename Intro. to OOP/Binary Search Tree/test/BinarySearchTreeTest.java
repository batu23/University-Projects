package cmpe160.s20151.project3.test;

import static org.junit.Assert.*;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.Random;

import org.junit.Before;
import org.junit.Test;

import cmpe160.s20151.project3.BinarySearchTree;

public class BinarySearchTreeTest {

	
	private static final Integer[] RANDOM_NUMBERS_1 = { 16, 22, 11, 6, 1, 10, 20, 7, 4, 5, 36, 29, 25, 44};
	private static final Integer[] RANDOM_NUMBERS_2 = { 54, 57, 13, 16, 32, 30, 91, 82, 48, 77, 23, 99};
	
	BinarySearchTree tree1,tree2;
	ArrayList<Integer> list1, list2;
	Random r;
	
	
	/**
	 * Constructs 2 binary tree for all tests
	 */
	@Before
	public void ConstructTest(){
	
		tree1 = new BinarySearchTree();
		
		list1 =  new ArrayList<Integer>(Arrays.asList(RANDOM_NUMBERS_1));
		
		for (int i : list1) {
			tree1.insert(i);
		}
	
		tree2 = new BinarySearchTree();
		
		list2 =  new ArrayList<Integer>(Arrays.asList(RANDOM_NUMBERS_2));
		
		for (int i : list2) {
			tree2.insert(i);
		}
		
		r=new Random();
	}
	
	
	
	@Test
	public void testSize() {
		
		
		try {
			assertTrue(tree1.size()==14);
			System.out.println( "The 1. test for 'Size' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 1. test for 'Size' has FAILED");
		
			throw e;
		}
		

		try {
			assertTrue(tree2.size()==12);
			System.out.println( "The 2. test for 'Size' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 2. test for 'Size' has FAILED");
		
			throw e;
		}
	}

	@Test
	public void testContains1() {
		boolean assertion=false;
		int a,b,c;
		
		a=list1.get(r.nextInt(list1.size()));
		b=list1.get(r.nextInt(list1.size()));
		c=list1.get(r.nextInt(list1.size()));
		
		
		if(tree1.contains(a) && tree1.contains(b) && tree1.contains(c))
			assertion=true;
		
		try {
			assertTrue(assertion);
			System.out.println( "The 1. test for 'Contains' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 1. test for 'Contains' has FAILED");
		
			throw e;
		}
		
	}
	
	@Test 
	public void testContains2() {
		
		boolean assertion=false;
		int a,b,c;
		
		a=list2.get(r.nextInt(list2.size()));
		b=list2.get(r.nextInt(list2.size()));
		c=list2.get(r.nextInt(list2.size()));
		
		
		if(tree2.contains(a) && tree2.contains(b) && tree2.contains(c))
			assertion=true;
		
		try {
			assertTrue(assertion);
			System.out.println( "The 2. test for 'Contains' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 2. test for 'Contains' has FAILED");
		
			throw e;
		}
		
	}


	@Test
	public void testDeleteInt1() {
		
		boolean assertion=true;
		
		ArrayList<Integer> deleted = new ArrayList<Integer>();
		int temp;
		for(int i=0; i < list1.size()/2; i++){
			temp= r.nextInt(list1.size());
			deleted.add(temp);
			tree1.delete(temp);
		}
		
		for(int i=0 ; i<deleted.size(); i++){
			if(tree1.contains(deleted.get(i)))
				assertion=false;
		}
		
		try {
			assertTrue(assertion);
			System.out.println( "The 1. test for 'Delete' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 1. test for 'Delete' has FAILED");
		
			throw e;
		}

		
	}
	
	@Test
	public void testDeleteInt2() {
		
		boolean assertion=true;
		
		ArrayList<Integer> deleted = new ArrayList<Integer>();
		int temp;
		for(int i=0; i < list2.size()/2; i++){
			temp= r.nextInt(list2.size());
			deleted.add(temp);
			tree2.delete(temp);
		}
		
		for(int i=0 ; i<deleted.size(); i++){
			if(tree2.contains(deleted.get(i)))
				assertion=false;
		}
		
		try {
			assertTrue(assertion);
			System.out.println( "The 2. test for 'Delete' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 2. test for 'Delete' has FAILED");
		
			throw e;
		}

		
	}

	@Test
	public void testHeight() {

		try {
			assertTrue(tree1.height()==5);
			System.out.println( "The test for 'Height' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The test for 'Height' has FAILED");
		
			throw e;
		}
	}


	@Test
	public void testLevelNodeInt() {
		
		
		try {
			assertTrue(tree1.level(tree1.getRoot(),20)==3 && tree2.level(tree2.getRoot(),82)==4);
			System.out.println( "The test for 'Level' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The test for 'Level' has FAILED");
		
			throw e;
		}
	}

	@Test(timeout=100)
	public void testAreCousins1() {
	
		String cousin_sol_1="1-29 1-44 4-7 4-25 6-20 6-36 7-4 7-25 10-29 10-44 20-6 25-4 25-7 29-1 29-10 36-6 44-1 44-10 ";
		
		String s = "";
		for (int i = 1; i <= 44; i++) {
			for (int j = 1; j <= 44; j++) {
				if (tree1.areCousins(i, j)) {
					s += i + "-" + j + " ";
				}
			}
		}
	
		
		try {
			assertTrue(s.contentEquals(cousin_sol_1));
			System.out.println( "The 1. test for 'AreCousins' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 1. test for 'AreCousins' has FAILED");
		
			throw e;
		}
		
	}
	
	@Test(timeout=100)
	public void testAreCousins2() {
	
		String cousin_sol_2="16-91 30-77 32-82 32-99 48-77 77-30 77-48 82-32 91-16 99-32 ";
		
		String s = "";
		for (int i = 1; i <= 99; i++) {
			for (int j = 1; j <= 99; j++) {
				if (tree2.areCousins(i, j)) {
					s += i + "-" + j + " ";
				}
			}
		}

		
		try {
			assertTrue(s.contentEquals(cousin_sol_2));
			System.out.println( "The 2. test for 'AreCousins' is SUCCESSFUL");
			
		} catch (AssertionError e) {
			System.out.println( "The 2. test for 'AreCousins' has FAILED");
		
			throw e;
		}
		
	}
}
