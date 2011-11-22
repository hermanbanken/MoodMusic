package jfftw;

import java.io.*;

/**
 * Wisdom represents all information FFTW has gathered during
 * the creation of plans. It is useful to save this information
 * for later use on the same machine. The following methods
 * provide this functionality.
 * <p>For a more detailed discussion see the
 * <a href="http://www.fftw.org">FFTW</a>
 documentation.
 * The FFTW library is work of MIT. The jfftw package is
 * work of Daniel Darabos

 * (<a href="mailto:cyhawk@sch.bme.hu">cyhawk@sch.bme.hu</a>).

 * Both have GPL licenses.
 */
public class Wisdom
{
/**
 * Prevent instantiation.
 */
	private Wisdom(){}
/**
 * Saves wisdom information to a file.
 */
	public static void save( File file ) throws IOException
	{
		BufferedWriter out = new BufferedWriter( new OutputStreamWriter( new FileOutputStream( file ) ) );
		String wisdom = get();
		out.write( wisdom, 0, wisdom.length() );
		out.close();
	}
/**
 * Returns wisdom information as a string.
 */
	public native static String get();
/**
 * Loads wisdom information from a file. The information is
 * added to existing information. In case of conflicting
 * data, the loaded replaces the already existing.
 */
	public static void load( File file ) throws IOException
	{
		BufferedReader in = new BufferedReader( new InputStreamReader( new FileInputStream( file ) ) );
		CharArrayWriter tmp = new CharArrayWriter();
		int c;
		while( (c = in.read()) != -1 )
		{
			tmp.write( c );
		}
		in.close();
		try
		{
			add( new String( tmp.toCharArray() ) );
		}
		catch( IllegalArgumentException e )
		{
			throw new IOException( "badly formatted wisdom file" );
		}
	}
/**
 * Loads wisdom information from a string. The information is
 * added to existing information. In case of conflicting
 * data, the loaded replaces the already existing.
 * @throws IllegalArgumentException if <code>wisdom</code>
 * is not of the expected format.
 */
	public native static void add( String wisdom ) throws IllegalArgumentException;
/**
 * Discards existing wisdom information.
 */
	public native static void clear();

	static 
	{
		System.loadLibrary( "jfftw" );
	}
}
