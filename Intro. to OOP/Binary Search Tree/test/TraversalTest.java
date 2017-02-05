package cmpe160.s20151.project3.test;

import static org.junit.Assert.*;

import java.util.ArrayList;
import java.util.Arrays;

import org.junit.Test;

import cmpe160.s20151.project3.BinarySearchTree;


public class TraversalTest {

	
	String test = null;
	String description = null;
	String correct = null;

	private static final Integer[] RANDOM_NUMBERS_1 = { 16, 22, 11, 6, 1, 10, 20, 7, 4, 5, 36, 29 };
	private static final Integer[] RANDOM_NUMBERS_2 = { 54, 57, 13, 16, 32, 30, 91, 82, 48, 77, 23, 99};

	private static final String SOL_1_INORDER = "[1, 4, 5, 6, 7, 10, 11, 16, 20, 22, 29, 36]";
	private static final String SOL_2_INORDER = "[13, 16, 23, 30, 32, 48, 54, 57, 77, 82, 91, 99]";
	private static final String SOL_1_SPIRAL = "[16, 11, 22, 6, 20, 36, 1, 10, 29, 4, 7, 5]";
	private static final String SOL_2_SPIRAL = "[54, 13, 57, 16, 91, 32, 82, 99, 30, 48, 77, 23]";
	
	
	
	@Test
	public void testInOrderTraversal1() {


		test = "Inorder Traversal Test-1";
		description = "Inorder Traversal is tested with input " + Arrays.toString(RANDOM_NUMBERS_1);

		try {
			
			BinarySearchTree tr = new BinarySearchTree();
			
			ArrayList<Integer> list =  new ArrayList<Integer>(Arrays.asList(RANDOM_NUMBERS_1));
			
			for (int i : list) {
				tr.insert(i);
			}

			ArrayList<Integer> answer=tr.inOrderTraversal();
			// test
			compareString(answer.toString(), test, description, SOL_1_INORDER);
		
		
		
		} catch (Exception e) {
			System.out.println("\tFAILED, exception (of " + e.getClass() + ") thrown while executing the code");
		}
		
		
		
	}
	
	@Test
	public void testInOrderTraversal2() {


		test = "Inorder Traversal Test-2";
		description = "Inorder Traversal is tested with input " + Arrays.toString(RANDOM_NUMBERS_2);

		try {
			
			BinarySearchTree tr = new BinarySearchTree();
			
			ArrayList<Integer> list =  new ArrayList<Integer>(Arrays.asList(RANDOM_NUMBERS_2));
			
			for (int i : list) {
				tr.insert(i);
			}

			ArrayList<Integer> answer=tr.inOrderTraversal();
			// test
			compareString(answer.toString(), test, description, SOL_2_INORDER);
		
		
		
		} catch (Exception e) {
			System.out.println("\tFAILED, exception (of " + e.getClass() + ") thrown while executing the code");
		}
		
		
		
	}

	@Test
	public void testSpiralTraversal1() {
		
		
		test = "Spiral Traversal Test-1";
		description = "Spiral Traversal is tested with input " + Arrays.toString(RANDOM_NUMBERS_1);

		try {
			
			BinarySearchTree tr = new BinarySearchTree();
			
			ArrayList<Integer> list =  new ArrayList<Integer>(Arrays.asList(RANDOM_NUMBERS_1));
			
			for (int i : list) {
				tr.insert(i);
			}

			ArrayList<Integer> answer=tr.spiralTraversal();
			// test
			compareString(answer.toString(), test, description, SOL_1_SPIRAL);
		
		
		
		} catch (Exception e) {
			System.out.println("\tFAILED, exception (of " + e.getClass() + ") thrown while executing the code");
		}
	}
	
	@Test
	public void testSpiralTraversal2() {
		
		
		test = "Spiral Traversal Test-2";
		description = "Spiral Traversal is tested with input " + Arrays.toString(RANDOM_NUMBERS_2);

		try {
			
			BinarySearchTree tr = new BinarySearchTree();
			
			ArrayList<Integer> list =  new ArrayList<Integer>(Arrays.asList(RANDOM_NUMBERS_2));
			
			for (int i : list) {
				tr.insert(i);
			}

			ArrayList<Integer> answer=tr.spiralTraversal();
			// test
			compareString(answer.toString(), test, description, SOL_2_SPIRAL);
		
		
		
		} catch (Exception e) {
			System.out.println("\tFAILED, exception (of " + e.getClass() + ") thrown while executing the code");
		}
	}
	
	
	private void compareString(Object object, String test,String description, String correct) {
		
		String experimental = null;
		try {
			experimental = object.toString();
			verify(test, description, correct, experimental,null);
		} catch (Exception e) {
			verify(test, description, correct, null, e);
		}
	}
	
	private static void verify(String test, String description, String correct,	String experimental, Exception ee) {
		
		System.out.println("\nTEST:\t" + test);
		System.out.println("\tdescription:\t" + description);
		System.out.println("\tCorrect:\t" + correct);
		
		if (ee == null) {
			// runs
			System.out.println("\tYours:  \t" + experimental);
			try {
				assertTrue(correct.equals(experimental));
				System.out.println( "\tSUCCESS");
				
			} catch (AssertionError e) {
				System.out.println( "\tFAILED");
			
				throw e;
			}
		} else {
			// failed to run
			System.out.println("\tYour code failed to run: " + ee.getClass());
			System.out.println("\tFAILED");
	
		}
	}

}
