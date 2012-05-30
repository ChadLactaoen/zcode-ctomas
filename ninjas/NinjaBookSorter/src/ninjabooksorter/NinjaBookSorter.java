package ninjabooksorter;

import java.util.Arrays;
import java.util.Comparator;

/**
 * NinjaBookSorter sorts ninja-related books in alphabetical order and can
 * print the books as if on a bookshelf. Intended for Zappos.Code();
 * 
 * @author Chad Tomas
 */
public class NinjaBookSorter {
    
    private String[] books;
    
    /**
     * Creates a new ninja book sorter
     * 
     * @param books The books to be sorted
     */
    public NinjaBookSorter(String[] books) {
        this.books = books;
    }
    
    /**
     * Sorts the books in alphabetical order
     */
    public void sort() {
        Arrays.sort(books, new Comparator() {
            @Override
            public int compare(Object o1, Object o2) {
                String s1 = (String)o1;
                String s2 = (String)o2;
                return s1.compareToIgnoreCase(s2);
            }
        });
    }   
    
    /**
     * Prints book titles downward as if on a bookshelf
     */
    public void printBookshelf() {
        int startPos, titlePos;
        int columns = books.length;
        int rows = getMaxTitleLength();        
        int maxLength = getMaxTitleLength();
        char[][] bookshelf = new char[rows][columns];
        int bookNum = 0;
        // Fills the bookshelf array with the book titles
        for(String s : books) {
            startPos = maxLength - s.length();
            titlePos = 0;
            for(int i = startPos; i < bookshelf.length; i++) {
                bookshelf[i][bookNum] = s.charAt(titlePos);
                titlePos++;
            }
            bookNum++;
        }        
        // Prints the book titles downward
        for (int j = 0; j < rows; j++) {
            for (int i = 0; i < columns; i++) {
                System.out.print(Character.toString(bookshelf[j][i]) + " ");
            }
            System.out.println("");
        }
    }
    
    /**
     * Called when printing the bookshelf, gets the length of the longest
     * book title to generate a properly sized array
     * 
     * @return The length of the longest book title in the collection
     */
    private int getMaxTitleLength() {
        int max = 0;
        for(String s : books)
            if(s.length() > max)
                max = s.length();
        return max;
    }
    
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        String[] books = {
          "So You Wanna Be A Ninja?", "Silent But Deadly", "Ninja, Please",
          "Ninja vs Ninja", "Happy Ninja", "101 Different Uses for Shurikens",
          "Pirates vs Ninjas", "Ninjas for Dummies", "Ninja Outfit Ideas",
          "How to Tip-Toe", "The World According to Ninja"
        };
        NinjaBookSorter nbs = new NinjaBookSorter(books);
        nbs.sort();
        nbs.printBookshelf();
    }
}
