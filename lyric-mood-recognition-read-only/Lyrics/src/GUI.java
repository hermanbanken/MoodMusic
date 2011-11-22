import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import javax.swing.event.*;

//import Parse.Polarity;

import java.io.*;
import java.util.HashMap;

public class GUI extends JFrame implements ActionListener{//
	private final static boolean USE_STEMMING = true;
	
	JTextField tf;
	JTextArea ta;
	JScrollPane jsp;
	JButton bsend;
	JButton bok;
	JButton bnok;

    public GUI() {

    	super("Infering Song Moods from Lyrics");

    	JLabel lin = new JLabel("Input");
		JLabel lname = new JLabel("Song name:");
		JLabel llyrics = new JLabel("Lyrics:");
		Container cp = getContentPane();
		JPanel p1= new JPanel();
		JPanel p2= new JPanel();

		tf = new JTextField(20);
		ta=new JTextArea(20,30);
		jsp = new JScrollPane(ta);
		bsend = new JButton("Send");
		bsend.addActionListener(this);
		bok= new JButton("Agree");
		bnok = new JButton("Disagree");


//		tf.addActionListener(this);
//		jl=new JList();

    	GroupLayout layout = new GroupLayout(p1);
 		p1.setLayout(layout);
 		layout.setHorizontalGroup(
   layout.createSequentialGroup()
   	  .addComponent(lin)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
           .addComponent(lname)
           .addComponent(llyrics)
           .addComponent(bsend))
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
           .addComponent(tf)
           .addComponent(jsp))
);
layout.setVerticalGroup(
   layout.createSequentialGroup()
      .addComponent(lin)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
           .addComponent(lname)
           .addComponent(tf))
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
           .addComponent(llyrics)
           .addComponent(jsp))
      .addComponent(bsend)
);

cp.add(p1);

    //	setLayout(new BorderLayout(5,5));


//		getContentPane().add(ta);
	/*
	 * 		layout.setHorizontalGroup(
   layout.createSequentialGroup()
      .addComponent(lname)
      .addComponent(tf)
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.LEADING)
           .addComponent(jsp)
           .addComponent(bsend))
);
layout.setVerticalGroup(
   layout.createSequentialGroup()
      .addGroup(layout.createParallelGroup(GroupLayout.Alignment.BASELINE)
           .addComponent(lname)
           .addComponent(tf)
           .addComponent(jsp))
      .addComponent(bsend)
);

	 *	p1.add(new JLabel("Song name:"));
		p1.add(tf);
		cp.add(p1, BorderLayout.NORTH);
		cp.add(new JLabel("Lyrics:"));
		cp.add(new JScrollPane(ta));
		cp.add(send);
*/
		pack();
		setVisible(true);
		setDefaultCloseOperation(3);
    }

    	public void actionPerformed(ActionEvent ev){
		try{
			JButton jb = (JButton) ev.getSource();
			if(tf.getText().trim().length()==0 || ta.getText().trim().length()==0){
			//	JTextArea ta = (JTextArea)jsp.getComponent(1);
			//	System.out.println("talen= " + ta.getText().trim().length());

				Object[] message = new Object[] {"You must provide the title and the lyrics!"};
				Object[] options = new String[] {"OK"};

				JOptionPane op = new JOptionPane(message, JOptionPane.PLAIN_MESSAGE, JOptionPane.OK_CANCEL_OPTION, null, options);
				JDialog dialog = op.createDialog(null, "Error");
				dialog.setVisible(true);
			}
			else{
				String root = "../test-lyrics/";
				String posDir = root + "pos";
				String negDir = root + "neg";
				String excludedWordsFileName = root + "excluded.txt"; 
				
				String fname = new String(tf.getText().trim()+".txt");
				String fisierTest = root + "test.txt";
				System.out.println("fis de test:"+fisierTest);
				String fcontent = new String(ta.getText().trim());
			//	System.out.println("fname="+fname);
			//	System.out.println("Content:\n"+fcontent);
				RandomAccessFile raf = new RandomAccessFile(fisierTest, "rw");
				raf.write(fcontent.getBytes());
				raf.close();
				tf.setText("");
				ta.setText("");
				
				
				Parse p = new Parse();
				//String fisierTest1 = root + "testneg.txt";
				String[] excludedWords = p.strToWords(p.readFile(excludedWordsFileName)).toArray(new String[0]);
			
				HashMap<String, Parse.Polarity> wordBase = p.computePolarity(posDir, negDir, excludedWords);
				/*
				for(String word: wordBase.keySet())
				{
					System.out.println(word + " " + wordBase.get(word));
				}
				*/
				Parse.Polarity pol = p.tagFile(fisierTest, wordBase);
				System.out.println("In gui !!!!!!!!!!! "+ pol + (pol.positive > pol.negative ? "positive" : "negative"));
				
				Object[] message = new Object[] {"POS: ", pol.positive, "NEG: ", pol.negative};
				Object[] options = new String[] {"Agree", "Disagree"};
				JOptionPane pane = new JOptionPane(message, JOptionPane.PLAIN_MESSAGE, JOptionPane.OK_CANCEL_OPTION, null, options);
				JDialog dialog = pane.createDialog(null, "Results");
				dialog.setVisible(true);
				
				Object selectedValue = pane.getValue();
			     if(selectedValue == null)
			    	 System.out.println("Nimic selectat");
			     //  return CLOSED_OPTION;
			     //If there is not an array of option buttons:
			   /*  if(options == null) {
			       if(selectedValue instanceof Integer)
			          return ((Integer)selectedValue).intValue();
			       return CLOSED_OPTION;
			     }*/
			     //If there is an array of option buttons:
			    /* for(int counter = 0, maxCounter = options.length;
			        counter < maxCounter; counter++) {
			        if(options[counter].equals(selectedValue))
			        	System.out.println("A selectat:" + counter);
			     }*/
		//	     return CLOSED_OPTION;
			     String moveto = "";
			     if(options[0].equals(selectedValue)){
			    	 System.out.println("A selectat: ok");
			    	 if(pol.positive > pol.negative)
			    		 moveto = "../test-lyrics/pos/" + fname;
			    	 else
			    		 moveto = "../test-lyrics/neg/" + fname;
			    	 System.out.println("Muta in:"+moveto);
			    	 raf = new RandomAccessFile(moveto, "rw");
						raf.write(fcontent.getBytes());
						raf.close();
			    	 
			     }
			     if(options[1].equals(selectedValue)){
			    	 System.out.println("A selectat: not ok");
			    	 if(pol.positive < pol.negative)
			    		 moveto = "../test-lyrics/pos/" + fname;
			    	 else
			    		 moveto = "../test-lyrics/neg/" + fname;
			    	 System.out.println("Muta in:"+moveto);
			    	 raf = new RandomAccessFile(moveto, "rw");
						raf.write(fcontent.getBytes());
						raf.close();
			    	 
			     }

			}


		}
		catch(Exception e){};
	}


    public static void main(String args[]){
    	GUI f = new GUI();

		//JTextField tf = new JTextField()
    }
}