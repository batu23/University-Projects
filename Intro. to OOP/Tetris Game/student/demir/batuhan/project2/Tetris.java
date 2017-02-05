package student.demir.batuhan.project2;

import java.awt.event.KeyEvent;
import java.awt.event.KeyListener;
import drawing_framework.AnimationCanvas;
import drawing_framework.GUI;

/**
 * classic tetris game, 
 * use left right keys to move
 * and up, down keys to rotate
 * use space to accelerate the shape and P to Pause
 * @author Batuhan
 *
 */
public class Tetris implements KeyListener {

	TetrisGame game;
	private static final int FRAME_RATE = 20;
	AnimationCanvas gameCanvas;
	private int move_frame_interval;
	boolean isPaused=false;
	/**
	 * creates the tetris game and starts the animation 
	 * @param gui
	 */
	public Tetris(GUI gui){
		
		this.move_frame_interval=8;
		
		gameCanvas = new AnimationCanvas(FRAME_RATE);
		gui.addCanvas(gameCanvas);
		
		gameCanvas.setFocusable(true);
		gameCanvas.addKeyListener(this);
		
		game=new TetrisGame(this,move_frame_interval);
		gameCanvas.addObject(game);
			
		gameCanvas.start();
		
	}

	@Override
	public void keyPressed(KeyEvent e) {
		 
		//handles the keyboard inputs
			switch(e.getKeyCode()){
		case KeyEvent.VK_SPACE:
				game.setMoveFrameInterval(0);
			break;
		case KeyEvent.VK_LEFT:
			if( game.isValid(game.getCurrentShape(), game.getCurrentCol() - 1, game.getCurrentRow(), game.getCurrentRot())) {
				game.setCurrentCol(game.getCurrentCol()-1);
			}
			break;
		case KeyEvent.VK_RIGHT:
			if( game.isValid(game.getCurrentShape(), game.getCurrentCol() + 1, game.getCurrentRow(), game.getCurrentRot())) {
				game.setCurrentCol(game.getCurrentCol()+1);
			}
			break;
		case KeyEvent.VK_DOWN:
			
				game.rotShape((game.getCurrentRot() == 0) ? 3 : game.getCurrentRot() - 1);
			
			break;
		case KeyEvent.VK_UP:
		
				game.rotShape((game.getCurrentRot() == 3) ? 0 : game.getCurrentRot() + 1);
			
			break;
		case KeyEvent.VK_P:
			if(isPaused){
				gameCanvas.start();
				isPaused=false;
			}
			else{
				gameCanvas.stop();
				isPaused=true;
			}
			break;
		}
		
}

	@Override
	public void keyReleased(KeyEvent e) {
		
		switch(e.getKeyCode()){
		
		case KeyEvent.VK_SPACE:
				game.setMoveFrameInterval(move_frame_interval);
			break;
		}
		
		
	}

	@Override
	public void keyTyped(KeyEvent e) {
		// TODO Auto-generated method stub
		
	}
	
	
}
