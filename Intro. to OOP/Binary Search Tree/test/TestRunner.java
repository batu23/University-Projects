package cmpe160.s20151.project3.test;

import org.junit.runner.JUnitCore;
import org.junit.runner.Result;
import org.junit.runner.notification.Failure;

public class TestRunner {
	public static void main(String[] args) {
		Result result = JUnitCore.runClasses(BinarySearchTreeTest.class,TraversalTest.class);
	      for (Failure failure : result.getFailures()) {
	         System.out.println(failure.toString());
	      }
	      if(result.wasSuccessful())
	      System.out.println("\n\t**********YOU HAVE PASSED ALL THE TESTS SUCCESFULLY**********");
	}

}
