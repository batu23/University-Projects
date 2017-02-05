package student.demir.batuhan.project2;

import java.awt.Color;
import java.util.Random;

import drawing_framework.Animatable;
import drawing_framework.AnimationCanvas;
/**
 * The class handles nearly all of the game logic. Draws and moves shapes every frame.
 * Classic tetris game
 * @author Batuhan
 *
 */
public class TetrisGame implements Animatable {
	

	protected final int COL_COUNT = 10;
	protected final int ROW_COUNT = 20;
	private static final int SHAPE_COUNT = Shapes.values().length;
	private boolean isGameOver;	
	private Random r;
	private Shapes currentShape,nextShape;
	private int currentCol,currentRow, currentRot, score;
	private int frameCounter, moveFrameInterval;
	Shapes[][] shapes;
	Tetris tetris;
	TetrisAI ai;

	
	/**
	 * Initialize the shape and constructs the game
	 * @param tetris game that tetris belongs to
	 * @param moveFrameInterval tetris is moved only once per moveFrameInterval number of frames
	 */
	public TetrisGame(Tetris tetris,int moveFrameInterval){
		
		this.tetris=tetris;
		
		r=new Random();
		
		frameCounter = 0;
		this.moveFrameInterval = moveFrameInterval;
				
		shapes = new Shapes[ROW_COUNT][COL_COUNT];
		this.nextShape = Shapes.values()[r.nextInt(SHAPE_COUNT)];
	
		this.currentShape = nextShape;
		this.currentCol = currentShape.getSpawn_col();
		this.currentRow = currentShape.getSpawn_row();
		this.currentRot = 0;
		this.nextShape = Shapes.values()[r.nextInt(SHAPE_COUNT)];

		isGameOver=false;
	}
	
	
	/**
	 * constructor of the AI tetris
	 * @param ai tetrisAI game 
	 */
	public TetrisGame(TetrisAI ai){
		
		this.ai=ai;
		
		r=new Random();
		shapes = new Shapes[ROW_COUNT][COL_COUNT];
		this.nextShape = Shapes.values()[r.nextInt(SHAPE_COUNT)];
	
		this.currentShape = nextShape;
		this.currentCol = currentShape.getSpawn_col();
		this.currentRow = currentShape.getSpawn_row();
		this.currentRot = 0;
		this.nextShape = Shapes.values()[r.nextInt(SHAPE_COUNT)];

		isGameOver=false;
	}
	/**
	 * creates a new shape
	 */
	protected void newShape(){
		
		this.currentShape = nextShape;
		this.currentCol = currentShape.getSpawn_col();
		this.currentRow = currentShape.getSpawn_row();
		this.currentRot = 0;
		this.nextShape = Shapes.values()[r.nextInt(SHAPE_COUNT)];
		
		if(!isValid(currentShape, currentCol, currentRow, currentRot)) {
			this.isGameOver = true;
			
		}		
	}
	/**
	 * rotates the shape
	 * @param newRot rotation will be done
	 */
	  public void rotShape(int newRot){
		
		int newCol = currentCol;
		int newRow = currentRow;		
		int left=currentShape.getLeftInclose(newRot);
		int right=currentShape.getRightInclose(newRot);
		int top=currentShape.getTopInclose(newRot);
		int bottom=currentShape.getBottomInclose(newRot);
		

		//if shape is far from edges, move away so that it doesn't become invalid
		if(currentCol < -left) {
			newCol -= currentCol - left;
		} else if(currentCol + currentShape.getDimension() - right >= COL_COUNT) {
			newCol -= (currentCol + currentShape.getDimension() - right) - COL_COUNT + 1;
		}

		//if shape is far from top or bottom, move away from
		if(currentRow < -top) {
			newRow -= currentRow - top;
		} else if(currentRow + currentShape.getDimension() - bottom >= ROW_COUNT) {
			newRow -= (currentRow + currentShape.getDimension() - bottom) -ROW_COUNT + 1;
		}
		 
		
		if(isValid(currentShape, newCol, newRow, newRot)) {
			currentRot = newRot;
			currentRow = newRow;
			currentCol = newCol;
		}
		 
		
	}
	  /**
	   * Determines the shape can be at the specified coordinates
	   * @param shape the shape will be used
	   * @param x the column 
	   * @param y the row
	   * @param rotation
	   * @return whether or not position is valid
	   */
	public boolean isValid(Shapes shape, int x, int y, int rotation) {
		
		//Look if shape is in a valid column.
		if(x < -shape.getLeftInclose(rotation)|| x + shape.getDimension() - shape.getRightInclose(rotation) >= COL_COUNT) {
			return false;
		}
		
		//Look if is in a valid row.
		if(y < -shape.getTopInclose(rotation) || y + shape.getDimension() - shape.getBottomInclose(rotation) >= ROW_COUNT) {
			return false;
		}

		//go over the shape and look if the position is occupied
		for(int col = 0; col < shape.getDimension(); col++) {
			for(int row = 0; row < shape.getDimension(); row++) {
				if(shape.containsShape(col, row, rotation) && hasOccupied(x + col, y + row)) {
					return false;
				}
			}
		}
		return true;
	}
	
	public boolean hasOccupied(int x, int y) {
		return shapes[y][x] != null;
	}
	/**
	 * Adds shape to the board
	 * @param shape shape to be added
	 * @param x the x coordinate
	 * @param y the y coordinate
	 * @param rotation rotation of shape
	 */
	public void addShape(Shapes shape, int x, int y, int rotation) {

		//go over the  shape and draw every box of it if only it is true
		for(int col = 0; col < shape.getDimension(); col++) {
			for(int row = 0; row < shape.getDimension(); row++) {
				if(shape.containsShape(col, row, rotation)) {
					setShape(col + x, row + y, shape);
				}
			}
		}
	}
	
	/**
	 * checks whether the line is full
	 * @param line the row will be looked
	 * @return whether the line empty or not
	 */
	public boolean isLineFull(int line) {

		for(int col = 0; col < COL_COUNT; col++) {
			if(!hasOccupied(col, line)) {
				return false;
			}
		}
		
		//if line is full delete it and down by one every row
		for(int row = line - 1; row >= 0; row--) {
			for(int col = 0; col < COL_COUNT; col++) {
				setShape(col, row + 1, getShape(col, row));
			}
		}
		return true;
	}
	/**
	 * @return number of completed lines
	 */
	public int fullLines() {
		int completedLines = 0;
		
		//look every line and give 50 points for every cleared line
		for(int row = 0; row < ROW_COUNT; row++) {
			if(isLineFull(row)) {
				completedLines++;
				score+=50;
			}
		}
		return completedLines;
	}
	
	
	
	
	@Override
	public void move(AnimationCanvas canvas) {
		
		if(isGameOver)
			return;	
		
			frameCounter++;
		//move the shape once every frame counter
		if (frameCounter > moveFrameInterval) {
			
			if(isValid(currentShape, currentCol, currentRow + 1, currentRot)) {				
				currentRow++;
			} else {

				addShape(currentShape, currentCol, currentRow, currentRot);
				
				//clear the full line and score
				int cleared =fullLines();
				if(cleared > 0) {
					 cleared=0;
				}
			
				newShape();
		}
		
			frameCounter = 0;
		
		}
		
		Shapes shape = getCurrentShape();
		int pieceCol = getCurrentCol();
		int pieceRow = getCurrentRow();
		int rotation = getCurrentRot();
		
		//draw the shape
		for(int col = 0; col < shape.getDimension(); col++) {
			for(int row = 0; row < shape.getDimension(); row++) {
				if( shape.containsShape(col, row, rotation)) {
					canvas.fillGridSquare(pieceCol + col, pieceRow + row ,shape.getColor());
				}
			}
		}
		
	}


	@Override
	public void draw(AnimationCanvas canvas) {
		
		for(int x = 0; x < COL_COUNT; x++) {
			for(int y = 0; y < ROW_COUNT; y++) {
				Shapes shape = getShape(x, y);
				if(shape != null) {
					canvas.fillGridSquare(x, y, shape.getColor());
				}
			}
		}
		
		
		if (isGameOver) {
			
			canvas.drawText("YOUR SCORE IS ->" + score, canvas.getGridWidth()/2-2, canvas.getGridHeight()/2-1, Color.BLUE.darker());
			canvas.drawText("GAME OVER", canvas.getGridWidth()/2-1, canvas.getGridHeight()/2, Color.RED);
		}
		
	}
	
	private void setShape(int  x, int y, Shapes shape) {
		shapes[y][x] = shape;
	}
		
	protected Shapes getShape(int x, int y) {
		return shapes[y][x];
	}


	public Shapes getCurrentShape() {
		return currentShape;
	}

	public int getCurrentCol() {
		return currentCol;
	}

	public int getCurrentRow() {
		return currentRow;
	}

	public int getCurrentRot() {
		return currentRot;
	}

	public void setCurrentCol(int currentCol) {
		this.currentCol = currentCol;
	}
	
	public void setCurrentRow(int currentRow) {
		this.currentRow = currentRow;
	}

	public boolean isGameOver() {
		return isGameOver;
	}


	public int getMoveFrameInterval() {
		return moveFrameInterval;
	}

	public void setMoveFrameInterval(int moveFrameInterval) {
		this.moveFrameInterval = moveFrameInterval;
	}

}
