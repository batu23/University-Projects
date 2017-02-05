package student.demir.batuhan.project2;

import java.awt.Color;

/**
 * describes shapes in advance and hold them in 3-dim boolean array
 * every shape has columns, rows and rotations
 * true values determines the spaces of the shape
 * there are 7 type of shape in tetris holds them in enumeration 
 * @author Batuhan
 *
 */
public enum Shapes {
	
	O_Shape(Color.BLACK, 2, 2, 2, new boolean[][] {
		{
			true,	true,
			true,	true,
		},
		{
			true,	true,
			true,	true,
		},
		{	
			true,	true,
			true,	true,
		},
		{
			true,	true,
			true,	true,
		}
	}),
	
	I_Shape(Color.RED, 4, 4, 1, new boolean[][] {
		{
			false,	false,	false,	false,
			true,	true,	true,	true,
			false,	false,	false,	false,
			false,	false,	false,	false,
		},
		{
			false,	false,	true,	false,
			false,	false,	true,	false,
			false,	false,	true,	false,
			false,	false,	true,	false,
		},
		{
			false,	false,	false,	false,
			false,	false,	false,	false,
			true,	true,	true,	true,
			false,	false,	false,	false,
		},
		{
			false,	true,	false,	false,
			false,	true,	false,	false,
			false,	true,	false,	false,
			false,	true,	false,	false,
		}
	}),
	
	S_Shape(Color.GREEN, 3, 3, 2, new boolean[][] {
		{
			false,	true,	true,
			true,	true,	false,
			false,	false,	false,
		},
		{
			false,	true,	false,
			false,	true,	true,
			false,	false,	true,
		},
		{
			false,	false,	false,
			false,	true,	true,
			true,	true,	false,
		},
		{
			true,	false,	false,
			true,	true,	false,
			false,	true,	false,
		}
	}),
	
	Z_Shape(Color.BLUE, 3, 3, 2, new boolean[][] {
		{
			true,	true,	false,
			false,	true,	true,
			false,	false,	false,
		},
		{
			false,	false,	true,
			false,	true,	true,
			false,	true,	false,
		},
		{
			false,	false,	false,
			true,	true,	false,
			false,	true,	true,
		},
		{
			false,	true,	false,
			true,	true,	false,
			true,	false,	false,
		}
	}),
	
	L_Shape(Color.YELLOW.darker(), 3, 3, 2, new boolean[][] {
		{
			false,	false,	true,
			true,	true,	true,
			false,	false,	false,
		},
		{
			false,	true,	false,
			false,	true,	false,
			false,	true,	true,
		},
		{
			false,	false,	false,
			true,	true,	true,
			true,	false,	false,
		},
		{
			true,	true,	false,
			false,	true,	false,
			false,	true,	false,
		}
	}),
	
	J_Shape(Color.ORANGE, 3, 3, 2, new boolean[][] {
		{
			true,	false,	false,
			true,	true,	true,
			false,	false,	false,
		},
		{
			false,	true,	true,
			false,	true,	false,
			false,	true,	false,
		},
		{
			false,	false,	false,
			true,	true,	true,
			false,	false,	true,
		},
		{
			false,	true,	false,
			false,	true,	false,
			true,	true,	false,
		}
	}),
	
	T_Shape(Color.CYAN, 3, 3, 2, new boolean[][] {
		{
			false,	true,	false,
			true,	true,	true,
			false,	false,	false,
		},
		{
			false,	true,	false,
			false,	true,	true,
			false,	true,	false,
		},
		{
			false,	false,	false,
			true,	true,	true,
			false,	true,	false,
		},
		{
			false,	true,	false,
			true,	true,	false,
			false,	true,	false,
		}
	});
	
	private boolean[][] shapes;
	private int cols;
	private int rows;
	private int dimension;
	private int spawn_row;
	private int spawn_col;
	private Color color;
	
	
	private Shapes(Color color, int dimension, int cols, int rows, boolean[][] shapes){
		this.color=color;
		this.dimension=dimension;
		this.cols=cols;
		this.rows=rows;
		this.shapes=shapes;
		//when the shapes first born 
		this.spawn_col=4;
		this.spawn_row=getTopInclose(0);
		
	}


	public boolean[][] getShapes() {
		return shapes;
	}


	public int getCols() {
		return cols;
	}


	public int getRows() {
		return rows;
	}


	public int getDimension() {
		return dimension;
	}


	public int getSpawn_row() {
		return spawn_row;
	}


	public int getSpawn_col() {
		return spawn_col;
	}


	public Color getColor() {
		return color;
	}
	/**
	 * @param x the x coordinate of shape
	 * @param y the y coordinate of shape
	 * @param rotation the rotation of shape
	 * @return whether the given coordinates contains shape
	 */
	public boolean containsShape(int x, int y, int rotation) {
		return shapes[rotation][y * dimension + x];
	}
	/**
	 * @param rotation the given rot of the shape
	 * @return the empty columns on the right side of the shape
	 */
	public int getRightInclose(int rotation) {
		
		for(int x = dimension - 1; x >= 0; x--) {
			for(int y = 0; y < dimension; y++) {
				if(containsShape(x, y, rotation)) {
					return dimension - x;
				}
			}
		}
		return -1;
	}
	/**
	 * @param rotation the given rot of the shape
	 * @return the empty columns at the top of the shape
	 */
	public int getTopInclose(int rotation) {
		
		for(int y = 0; y < dimension; y++) {
			for(int x = 0; x < dimension; x++) {
				if(containsShape(x, y, rotation)) {
					return y;
				}
			}
		}
		return -1;
	}
	/**
	 * @param rotation the given rot of the shape
	 * @return the empty columns on the left side of the shape
	 */
	public int getLeftInclose(int rotation) {
		
		for(int x = 0; x < dimension; x++) {
			for(int y = 0; y < dimension; y++) {
				if(containsShape(x, y, rotation)) {
					return x;
				}
			}
		}
		return -1;
	}
	/**
	 * @param rotation the given rot of the shape
	 * @return the empty columns on the bottom of the shape
	 */
	public int getBottomInclose(int rotation) {
		
		for(int y = dimension - 1; y >= 0; y--) {
			for(int x = 0; x < dimension; x++) {
				if(containsShape(x, y, rotation)) {
					return dimension - y;
				}
			}
		}
		return -1;
	}
	
	
}
