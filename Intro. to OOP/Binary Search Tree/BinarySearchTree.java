package cmpe160.s20151.project3;

import interfaces.BSTInterface;

import java.util.*;



public class BinarySearchTree implements BSTInterface  {

	private Node root;

	/**
	 * Basic storage units in a tree.
	 * Each Node object has a left and right children fields.
	 * 
	 * If a node does not have a left and/or right child, its
	 * right and/or left child is null.
	 * @author Cagatay Yildiz
	 *
	 */
	private class Node {
		private int data;
		private Node left, right; // left and right subtrees

		public Node(int data) {
			this.data = data;
		}
	}
	// == CHANGE STARTS BELOW THIS LINE ==
	
	
	@Override
	public boolean isEmpty() {
		return root==null;
	}

	
	
	
	@Override
	public Integer size() {
		int result=size(root);
		return result;
	}
	private int size(Node root ) {
		   if ( root == null )
		      return 0;  
		   else {
		      int count = 1;   
		      count += size(root.left);  
		      count += size(root.right); 
		                                      
		      return count;  
		   }
		}
	

	
	
	
	@Override
	public boolean contains(int key) {
		return contains(key,root );
		
	}
	private boolean contains(int key, Node node ){
	
		if( node == null )
			return false;

		int compareResult = compareTo(key, node.data );
		
		if( compareResult < 0 )
			return contains( key, node.left );
		else if( compareResult > 0 )
			return contains( key, node.right );
		else
			return true; 
	}

	
	
	
	@Override
	public void insert(int key) {
		root=insert(key,root);
		
	}
	private Node insert(int key, Node node){
		if( node == null )
			return new Node(key);
			
		int compareResult = compareTo(key, node.data );
			
		if( compareResult < 0 )
			node.left = insert( key, node.left );
		else if( compareResult > 0 )
			node.right = insert( key, node.right );
		else
			; // do nothing
		return node;
	}

	
	
	
	@Override
	public void delete(int key) {
		root=delete(key,root);		
	}
	private Node delete(int key, Node node){
		
		if( node == null )
			return node; // Item not found; do nothing
			
		int compareResult = compareTo(key, node.data );
			
		if( compareResult < 0 )
			node.left = delete( key, node.left );
		else if( compareResult > 0 )
			node.right = delete( key, node.right );
		else if( node.left != null && node.right != null ) // Two children
		{
			node.data = findMin(node.right).data;
			node.right = delete(node.data,node.right);
		}
		else{
			if( node.left != null){
				node = node.left;
			}
			else
			 node= node.right;
		}	
			return node;
		
	}
	
	
	
	@Override
	public Integer height() {
		return height(root);
	}
	private int height(Node root){
		if (root == null) 
			return -1;
		else
			return 1 + Math.max(height(root.left), height(root.right));
	}
	
	
	
	@Override
	public boolean isBST() {
		
		return isBST(root,findMin(root),findMax(root));
	}
	private boolean isBST(Node root, Node min, Node max){
		if(root==null)
			return true;
		if(root.data < min.data || root.data > max.data)
			return false;
		
		return isBST(root.left, min , root) && isBST(root.right, root, max);
	}
	
	
	
	@Override
	public ArrayList<Integer> inOrderTraversal() {
		
		ArrayList<Integer> inorder = new ArrayList<Integer>();
		inOrderTraversal(root,inorder);
		return inorder;
	}
	private void inOrderTraversal(Node root,ArrayList<Integer> list){

		if( root != null ){
			inOrderTraversal( root.left, list );
			list.add(root.data);
			inOrderTraversal( root.right, list);
		}
	}
	
	
	
	@Override
	public ArrayList<Integer> spiralTraversal() {
		
		ArrayList<Integer> spiral = new ArrayList<Integer>();
		
		Queue<Node> level  = new LinkedList<>();
	     level.add(root);
	     while(!level.isEmpty()){
	         Node node = level.poll();
	         spiral.add(node.data);
	         if(node.left!= null)
	         level.add(node.left);
	         if(node.right!= null)
	         level.add(node.right);
	     }
	     
		return spiral;
	}
	
	
	
	/**
	 * checks whether given keys are cousins or not
	 */
	@Override
	public boolean areCousins(int key1, int key2) {
		
		if(!contains(key1) || !contains(key2) || key1==key2)
			return false;
		
		Node n1 = find(root,key1);
		Node n2 = find(root,key2);
		
		if(level(root,n1,1)==level(root,n2,1) && !isSibling(root,n1,n2)){
			return true;
		}
		return false;
	}
	
	public boolean isSibling(Node root,Node a,Node b){
	    // Base case
	    if (root==null)  
	    	return false;
	 
	    return ((root.left==a && root.right==b)|| (root.left==b && root.right==a) || isSibling(root.left, a, b)|| isSibling(root.right, a, b));
	}
	
	
	
	/**
	 * Finds the node that contains the value and returns a reference to the node.
	 * Returns null if value does not exist in the tree.                
	 * @param root
	 * @param value
	 * @return The found node
	 */
	public Node find(Node root, int value) {
	   
	    if (root == null) 
	    	return null;
	    if (root.data == value) {
	        return root;
	    } else {
	        Node left = find(root.left, value);
	        Node right = find(root.right, value);
	        if (left != null) {
	            return left;
	        }
	        	return right;
	           
	    }
	}
	
	
	
	
	
	public Node findMin(Node node){
		if( node == null )
			return null;
		else if( node.left == null )
			return node;
		return findMin( node.left );
	}
	
	public Node findMax(Node node){
		if( node != null )
			while( node.right != null )
				node= node.right;
			
			return node;
	}
	
	
	public int compareTo(int a, int b){
		if(a==b)
			return 0;
		else if(a>b)
			return 1;
		else
			return -1;
	}

	public Node getRoot() {
		return root;
	}
	
	
	
	
	public int level(Node root,int  key){
		int lev;
		
		Node n=find(root, key);
		lev=level(root, n, 1);
		
		return lev;
	}
	
	/**
	 * return the level of the given node
	 * @param root root of the tree
	 * @param given given node to be found
	 * @param lev level of the node
	 * @return
	 */
	public int level(Node root, Node given, int lev){  
		
		
		if(root==null || given==null)
			return 0;
		if(root==given)
			return lev;
		
		
		int cmp=compareTo(root.data, given.data);
		
		if(cmp>0)
			return level(root.left,given,lev+1);
		else
			return level(root.right,given,lev+1);
	}
	
	
	
/*	 public void printEachLevel(){
		    if (root == null) return;
		    
		    Queue<Node> queue = new LinkedList<Node>();
		    
		    queue.add(root);
		    
		    int countCurrentLevel = 1;
		    int countNextLevel = 0;
		  
		    Node node = null;
		    while (!queue.isEmpty()){
		      node = queue.remove();
		      System.out.print(String.format("%-4d", node.data));
		      countCurrentLevel--;
		      if (node.left != null){
		      	queue.add(node.left);
		      	countNextLevel++;
		      }
		      if (node.right != null){
		      	queue.add(node.right);
		      	countNextLevel++;
		      }
		      if (countCurrentLevel == 0){
		        System.out.println();
		        countCurrentLevel = countNextLevel;
		        countNextLevel = 0;
		      }
		      
		    }
		 
		
	}
*/
	
	// == CHANGE STOPS ABOVE THIS LINE ==
}
