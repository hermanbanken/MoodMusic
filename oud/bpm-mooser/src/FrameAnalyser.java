package src;

import org.mp3transform.Bitstream;
import org.mp3transform.Header;

public class FrameAnalyser implements IFrameHandler {

	@Override
	public void handleFrame(int frameid, Bitstream stream) {
		Header header = stream.readFrame();
		int channels = (header.mode() == Header.MODE_SINGLE_CHANNEL) ? 1 : 2;
        int freq = header.frequency();
        decoder.decodeFrame(header, stream);
        stream.closeFrame();
	}
	
	
}