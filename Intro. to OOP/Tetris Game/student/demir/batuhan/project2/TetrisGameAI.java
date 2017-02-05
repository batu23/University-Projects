package student.demir.batuhan.project2;

import drawing_framework.AnimationCanvas;
/**
 * the class tries to handle AI logic
 * it is a child of TetrisGame
 * @author Batuhan
 *
 */
public class TetrisGameAI extends TetrisGame {
	
	
	AnimationCanvas canvas;
	int width = super.COL_COUNT;
	int height = super.ROW_COUNT;
	/**
	 * AI game Constructor
	 * @param ai
	 */
	public TetrisGameAI(TetrisAI ai) {		
		super(ai);
	}

	/**
	 * @return the empty spaces
	 */
	private int avaliableSpaces(){
		int spaces=0;
		
		for(int i=height-1;i==0;i--){
			if(!super.isLineFull(i)){
				for(int m=0; m<width; m++){
					if(super.hasOccupied(m, i))
						spaces++;
				}
			}
		}
		return spaces;
	}
	/**
	 * @return number of open space whose upper box is occupied
	 */
	private int numberOfHoles() {
		
		int holes = 0;
		
		boolean above[] = new boolean[width];
		
		for ( int i = 0; i < width; i++ ) 
			above[i] = false;

		for ( int y = 1; y < height; y++ ) {
			if ( super.isLineFull(y) ) {
				for ( int x = 0; x < width; x++ ) {
					if ( super.hasOccupied(x, y) ) {
						above[x] = true;
					} else if ( above[x] ) {
						holes++;
					}
				}
			}
		}
		
		return holes;
	}
	
	/**
	 * @return highest point in the board that is full
	 */
	private int highest() {
		for ( int i = height-1; i == 0; i-- )
			if ( !super.isLineFull(i) )
				return height - i;
		
		return height-1;
	}
	
	/**
	 * @return lowest point in the board that is directly accessible by the I shape
	 */
	private int lowest() {
		boolean open[] = new boolean[width];
		
		for ( int i = 0; i < open.length; i++ ) 
			open[i] = true;
		
		int numOpen = open.length;
		
		for ( int y = 1; y < height; y++ ) {
			if ( super.isLineFull(y)) {
				for ( int x = 0; x < width; x++ ) {
					if ( open[x] ) {
						if (super.hasOccupied(x, y) ) {
							open[x] = false;
							numOpen--;
						}
					}
				}
				
				if (numOpen == 0) 
					return height - y;
			}
		}
		return 0;
	}
	
	private int heightDifference() {
		return highest() - lowest();
	}
	/**
	 * @return the number like the score of available place
	 */
	protected int evaluate() {
		return avaliableSpaces() + heightDifference() +(4 - super.fullLines()) +	
				numberOfHoles() + super.getCurrentShape().getCols();
	}
	/**
	 * the main logic of ai
	 * looks for best place to go
	 * compares the best x coordinates
	 */
	public void moveShape() {

		
		int bestVal = 1000000;
		int bestRot = 0;
		int bestX = 0;
		
		int tempVal = 0;
		
		for ( int rot = 0; rot < 4;rot++ ) {
			
			super.rotShape(rot);

			shiftPiece();
			
			tempVal = evaluate();
			if ( tempVal < bestVal ) {
				bestVal = tempVal;
				bestRot = super.getCurrentRot();
				bestX = super.getCurrentCol();
			}
		
			while(super.isValid(super.getCurrentShape(), super.getCurrentCol()+1, super.getCurrentRow(), super.getCurrentRot())) {
				super.setCurrentCol(super.getCurrentCol()+1);
			
				// Don't look at piece positions that aren't on the board
				if ( super.getCurrentCol() < 0 ) 
					continue;
				
				tempVal = evaluate(); 	
				if ( tempVal < bestVal ) {
					bestVal = tempVal;
					bestRot = super.getCurrentRot();
					bestX = super.getCurrentCol();
				}
			
			}

		}
		//move and rotate shape accordingly
		super.rotShape(bestRot);
		if(bestX>super.getCurrentCol())
			super.setCurrentCol(super.getCurrentCol()+1);
		if(bestX<super.getCurrentCol())
			super.setCurrentCol(super.getCurrentCol()-1);
		
	}

	/**
	 * shift piece left or right
	 */
	public void shiftPiece(){
		
		if( super.isValid(super.getCurrentShape(), super.getCurrentCol() - 1, super.getCurrentRow(), super.getCurrentRot())) {
			super.setCurrentCol(super.getCurrentCol()-1);
		}
		
		else if( super.isValid(super.getCurrentShape(), super.getCurrentCol() + 1, super.getCurrentRow(), super.getCurrentRot())) {
			super.setCurrentCol(super.getCurrentCol()+1);
		}
	}
	
	
}
