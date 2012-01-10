package src;

import javax.sound.sampled.*;
import org.mp3transform.wav.WavConverter;

public class BDMain {
    public BDMain() {

    }

    public static void main(String[] args) {
        BDMain bdmain = new BDMain();
        int i, r;
        double theta;
        int LEN = 44100;

        byte buffer[];
        AudioFileFormat af;
        AudioInputStream ais;
        Clip clip;

        byte b;
        float fl;

        SoundSample music = new SoundSample();
        SoundSample click = new SoundSample();
        
        //    music.loadWavFile("99 Luftballons.mp3");
		
        try {
        	WavConvert.main(new String[]{
			    	"-in", "music/99 Luftballons.mp3"});
            music.loadWavStream("out.wav");
        } catch (Exception e){
        	System.out.println(e.getStackTrace());
        }
        music.calcBands();
        music.diffBands();

        click.loadWavFile("music/click.wav");
        music.insertBeatClicks(click);

        music.play();

        System.exit(0);

    }
}
