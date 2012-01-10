import java.io.BufferedReader;
import java.io.File;
import java.io.FileReader;
import java.io.IOException;
import java.io.RandomAccessFile;
import java.text.BreakIterator;
import java.util.ArrayList;
import java.util.Collections;
import java.util.HashMap;
import java.util.HashSet;
import java.util.Locale;
import java.util.Set;
import java.awt.*;
import java.awt.event.*;

import javax.swing.*;
import javax.swing.event.*;
import java.io.*;

public class Parse
{
	private final static boolean USE_STEMMING = true;
	
	private static BreakIterator wordIterator = BreakIterator.getWordInstance(new Locale ("en","US"));


	public  String readFile(String filename) throws IOException
	{
		BufferedReader reader = new BufferedReader(new FileReader (filename));
		String line  = null;
		StringBuilder stringBuilder = new StringBuilder();
		String ls = System.getProperty("line.separator");
		while((line = reader.readLine()) != null)
		{
			stringBuilder.append(line);
			stringBuilder.append(ls);
		}
		return stringBuilder.toString();
	}


	public  ArrayList<String> strToWords(String text)
	{
		ArrayList<String> words = new ArrayList<String>();
		wordIterator.setText(text);
		int start = wordIterator.first();
		int end = wordIterator.next();

		while (end != BreakIterator.DONE)
		{
			String word = text.substring(start, end);
			if (Character.isLetterOrDigit(word.charAt(0)))
			{
				word = word.toLowerCase();
				
				if (word.endsWith("'ve"))
				{
					words.add(word.substring(0, word.indexOf('\'')));
					words.add("have");
				}
				else if (word.endsWith("'d"))
				{
					words.add(word.substring(0, word.indexOf('\'')));
					words.add("would");
				}
				else if (word.endsWith("'s"))
				{
					words.add(word.substring(0, word.indexOf('\'')));
					words.add("is");
				}
				else if (word.endsWith("'ll"))
				{
					words.add(word.substring(0, word.indexOf('\'')));
					words.add("will");
				}
				else if (word.endsWith("'re"))
				{
					words.add(word.substring(0, word.indexOf('\'')));
					words.add("are");
				}
				else if (word.endsWith("'m"))
				{
					words.add(word.substring(0, word.indexOf('\'')));
					words.add("am");
				}
				else if (word.endsWith("ing"))
				{
					// transform gerrunds to infinitive 
					words.add(word.substring(0, word.length() - 3));
				}
				/////
				else if (word.startsWith("un"))
				{
					words.add("not");
					words.add(word.substring(2, word.length()));
				}
				/////
				else if (word.startsWith("in"))
				{
					words.add("not");
					words.add(word.substring(2, word.length()));
				}
				else if (word.startsWith("mis"))
				{
					words.add("not");
					words.add(word.substring(3, word.length()));
				}
				else if (word.startsWith("non"))
				{
					words.add("not");
					words.add(word.substring(3, word.length()));
				}
				else if (word.equals("won't"))
				{
					words.add("will");
					words.add("not");
				}
				else if (word.equals("doesn't"))
				{
					words.add("does");
					words.add("not");
				}
				else if (word.equals("don't"))
				{
					words.add("do");
					words.add("not");
				}
				else if (word.equals("can't"))
				{
					words.add("can");
					words.add("not");
				}
				else 
					words.add(word);
			}
			start = end;
			end = wordIterator.next();
		}
		
		if (USE_STEMMING)
			words = reduceWordsToStem(words);
		
		return words;
	}

	public  ArrayList<String> reduceWordsToStem(ArrayList<String> words)
	{
		ArrayList<String> ret = new ArrayList<String>();
		for (String word : words) 
		{
			Stemmer s = new Stemmer(word);
			ret.add(s.toString());
		}
		return ret;
	}


	public  HashMap<String, Integer> countWords(ArrayList<String> wordlist)
	{
		HashMap<String, Integer> wordcount = new HashMap<String, Integer>();
		for (String word : wordlist)
		{
			if (wordcount.containsKey(word))
				wordcount.put(word, wordcount.get(word) + 1);
			else
				wordcount.put(word, 1);
		}
		return wordcount;
	}


	public  ArrayList<String> filterWordList(ArrayList<String> list, String[] excludedWords)
	{
		ArrayList<String> filteredWordList = new ArrayList<String>();
		for (String word:list)
		{
			boolean skip = false;
			for (String excludedWord:excludedWords)
				if (word.equals(excludedWord))
				{
					skip = true;
					break;
				}
			if (!skip)
				filteredWordList.add(word);
		}
		return filteredWordList;
	}
	
	public  HashMap<String,Integer> countDirWords(String numeDir, String[] excludedWords) throws IOException
	{
		File dir = new File(numeDir);
		ArrayList<String> allWordList = new ArrayList<String>();
		for (String file : dir.list())
		{
			if (file.startsWith("."))
				continue;
			String filename = numeDir + dir.separator + file;
			String text = readFile(filename);
			ArrayList<String> wordlist = strToWords(text);
			allWordList.addAll(wordlist);
		}

		
		return countWords(filterWordList(allWordList, excludedWords));
	}

	 class Polarity
	{
		public double positive, negative, neutral;
		public Polarity(double positive, double negative, double neutral)
		{
			this.positive = positive;
			this.negative = negative;
			this.neutral  = neutral;
		}		
		public String toString()
		{
			return "(pos=" + this.positive + ", neg=" + this.negative + ", neu=" + this.neutral + ")";
		}
		public void add(Polarity p)
		{
			this.positive += p.positive;
			this.negative += p.negative;
			this.neutral += p.neutral;
		}
	}
	 
	public  int countFiles(String numeDir)
	{
		File dir = new File(numeDir);
		return dir.list().length;
	}
	
	private  int sumInstances(HashMap<String,Integer> hash)
	{
		int n = 0;
		for(Integer i : hash.values())
			n += i.intValue();
		return n;
	}
	
	public  HashMap<String, Polarity> computePolarity(String posDir, String negDir, String [] excludedWords) throws IOException
	{
		HashMap<String,Integer> pos = countDirWords(posDir, excludedWords);
		HashMap<String,Integer> neg = countDirWords(negDir, excludedWords);
		double nrPosWords = sumInstances(pos);
		double nrNegWords = sumInstances(neg);
		
		Set<String> words = new HashSet<String>();
		words.addAll(pos.keySet());
		words.addAll(neg.keySet());
		
		HashMap<String, Polarity> wordBase = new HashMap<String, Polarity>();
		
		for(String word:words)
		{
			Integer posInstance = pos.get(word);
			Integer negInstance = neg.get(word);
			int posNr = posInstance == null ? 0 : posInstance.intValue();
			int negNr = negInstance == null ? 0 : negInstance.intValue();
			Polarity pol = new Polarity(posNr/nrPosWords, negNr/nrNegWords, 0);
			wordBase.put(word, pol);
		}
		
		return wordBase;
	}
	public  HashMap<String, Polarity> computePolarity2(String posDir, String negDir, String [] excludedWords) throws IOException
	{
		HashMap<String,Integer> pos = countDirWords(posDir, excludedWords);
		HashMap<String,Integer> neg = countDirWords(negDir, excludedWords);
		double nrAllWords = sumInstances(pos) + sumInstances(neg);
	
		Set<String> words = new HashSet<String>();
		words.addAll(pos.keySet());
		words.addAll(neg.keySet());
		
		HashMap<String, Polarity> wordBase = new HashMap<String, Polarity>();
		
		for(String word:words)
		{
			Integer posInstance = pos.get(word);
			Integer negInstance = neg.get(word);
			int posNr = posInstance == null ? 0 : posInstance.intValue();
			int negNr = negInstance == null ? 0 : negInstance.intValue();
			Polarity pol = new Polarity(posNr/nrAllWords, negNr/nrAllWords, (nrAllWords - posNr - negNr)/nrAllWords);
			wordBase.put(word, pol);
		}
		
		return wordBase;
	}


	public  Polarity tagFile(String fisierTest, HashMap<String, Polarity> wordBase) throws IOException
	{
		Polarity acc = new Polarity(0, 0, 0);
		int count = 0;
		ArrayList<String> allWords = strToWords(readFile(fisierTest));
		for(String word:allWords)
		{
			Polarity polarity = wordBase.get(word);
			if(polarity == null)
				continue;
			acc.add(polarity);
			count++;
		}
		
		return new Polarity(acc.positive/count, acc.negative/count, acc.neutral/count);
	}
	




	private static void printWordCounts(HashMap<String, Integer> wordcount)
	{
		ArrayList<Integer> values = new ArrayList<Integer>();
		values.addAll(wordcount.values());
		// and sorting it (in reverse order)
		Collections.sort(values, Collections.reverseOrder());

		int last_i = -1;
		// Now, for each value 
		for (Integer i : values)
		{
			if (last_i == i) // without dublicates 
				continue;
			last_i = i;
			// we print all hash keys 
			for (String s : wordcount.keySet())
			{
				if (wordcount.get(s) == i) // which have this value 
					System.out.println(s + ":" + i);
			}
			// pretty inefficient, but works 
		}
	}
	
	public static void main(String[] args) 
	{
		try {
			Parse p = new Parse();
			
			String root = "../test-lyrics/";
			String posDir = root + "pos";
			String negDir = root + "neg";
			String excludedWordsFileName = root + "excluded.txt"; 
			String fisierTest1 = root + "testpos.txt";
			//String fisierTest1 = root + "testneg.txt";
			
			
			String[] excludedWords = p.strToWords(p.readFile(excludedWordsFileName)).toArray(new String[0]);
			
			HashMap<String, Polarity> wordBase = p.computePolarity(posDir, negDir, excludedWords);
			/*
			for(String word: wordBase.keySet())
			{
				System.out.println(word + " " + wordBase.get(word));
			}
			*/
			Polarity pol = p.tagFile(fisierTest1, wordBase);
			System.out.println(pol + (pol.positive > pol.negative ? "positive" : "negative"));
			
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}

	}
	
}

