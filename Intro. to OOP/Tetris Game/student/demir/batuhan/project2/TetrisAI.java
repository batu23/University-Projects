package student.demir.batuhan.project2;


import drawing_framework.AnimationCanvas;
import drawing_framework.GUI;
/**
 * tetris game playing by computer
 * @author Batuhan
 *
 */
public class TetrisAI {
	
	TetrisGameAI ai;
	private static final int FRAME_RATE = 20;
	AnimationCanvas gameCanvas;
	
	public TetrisAI(GUI gui){

		gameCanvas = new AnimationCanvas(FRAME_RATE);
		gui.addCanvas(gameCanvas);
		
		gameCanvas.setFocusable(true);
		
		ai=new TetrisGameAI(this);
		gameCanvas.addObject(ai);
		gameCanvas.start();
	}
	
}


