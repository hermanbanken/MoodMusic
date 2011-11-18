package src;

import org.mp3transform.Bitstream;

interface IFrameHandler {
	public void handleFrame(int frameid, Bitstream stream);
}