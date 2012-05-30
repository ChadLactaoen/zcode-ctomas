package sudokugenerator;

import java.util.ArrayList;
import java.util.Random;

/**
 * SudokuGenerator generates a valid 9 x 9 sudoku grid. Intended for
 * Zappos.Code();
 *
 * @author Chad Tomas
 */
public class SudokuGenerator {

    private int[][] grid;
    private ArrayList[][] cellPossibles;
    private int[] numsPossible;
    private Random rand;

    /**
     * Creates a new sudoku puzzle generator
     */
    public SudokuGenerator() {
        grid = new int[9][9];
        cellPossibles = new ArrayList[9][9];
        rand = new Random();

        setCellPossibles();
    }

    /**
     * Clears all control structures in order to create a new sudoku puzzle
     */
    private void reset() {
        grid = new int[9][9];
        cellPossibles = new ArrayList[9][9];
        setCellPossibles();
    }

    /**
     * Initializes possible numbers for each cell in the puzzle
     */
    private void setCellPossibles() {
        for (int x = 0; x < 9; x++) {
            for (int y = 0; y < 9; y++) {
                cellPossibles[x][y] = new ArrayList<Integer>();
                for (int num = 1; num <= 9; num++) {
                    cellPossibles[x][y].add(num);
                }
            }
        }
    }

    /**
     * Fills three horizontally-adjacent grids in a sudoku puzzle
     *
     * @param startX The x-coordinate of the top-leftmost cell of the grids to
     * be filled
     * @param startY The y-coordinate of the top-leftmost cell of the grids to
     * be filled
     */
    private void fillThreeGrids(int startX, int startY) {
        numsPossible = fillNumsPossible(startX, startY);

        // Repeat 24 times until three grids are filled
        for (int i = 1; i <= 27; i++) {
            int smallestIndex = getSmallestCell();
            int x = startX + (smallestIndex / 9);
            int y = startY + (smallestIndex % 9);
            int num = (Integer) cellPossibles[x][y].get(rand.nextInt(cellPossibles[x][y].size()));

            grid[x][y] = num;
            cellPossibles[x][y].clear();
            removePossible(num, x, y);
            numsPossible = fillNumsPossible(startX, startY);
        }
    }

    /**
     * Finds the cell in the current grids being evaluated that has the smallest
     * number of possible numbers that can fill the cell without violating the
     * rules of sudoku. If there is a tie, the first cell is taken
     *
     * @return The integer corresponding to the cell's location in the array
     * holding the cell's number of eligible candidates
     */
    private int getSmallestCell() {
        int smallest = 10;
        int index = -1;
        for (int i = 0; i < numsPossible.length; i++) {
            if (numsPossible[i] < smallest && numsPossible[i] > 0) {
                smallest = numsPossible[i];
                index = i;
            }
        }
        numsPossible[index] = 0;
        return index;
    }

    /**
     * Fills the integer array of the current grids being evaluated containing
     * the number of eligible candidates for each cell
     *
     * @param startX The x-coordinate of the top-leftmost cell of the grids to
     * be filled
     * @param startY The y-coordinate of the top-leftmost cell of the grids to
     * be filled
     * @return The array containing the number of eligible candidates for each
     * cell
     */
    private int[] fillNumsPossible(int startX, int startY) {
        numsPossible = new int[27];
        int index = 0;

        for (int x = startX; x <= startX + 2; x++) {
            for (int y = startY; y <= startY + 8; y++) {
                numsPossible[index] = cellPossibles[x][y].size();
                index++;
            }
        }
        return numsPossible;
    }

    /**
     * Removes a number for the cell possibles for each cell in the same column
     * and row
     *
     * @param num The number to be removed
     * @param row The row which the number was placed
     * @param column The column which the number was placed
     */
    private void removePossible(int num, int row, int column) {
        int startX = (row / 3) * 3;
        int startY = (column / 3) * 3;
        // Removes number from cells in same grid
        for (int i = startX; i < startX + 3; i++) {
            for (int j = startY; j < startY + 3; j++) {
                cellPossibles[i][j].remove(new Integer(num));
            }
        }
        // Removes number from cells in same row
        for (int x = 0; x < 9; x++) {
            if (!cellPossibles[x][column].isEmpty()) {
                cellPossibles[x][column].remove(new Integer(num));
            }
        }
        // Removes number from cells in same column
        for (int y = 0; y < 9; y++) {
            if (!cellPossibles[row][y].isEmpty()) {
                cellPossibles[row][y].remove(new Integer(num));
            }
        }
    }

    /**
     * Prints the 9 X 9 sudoku puzzle
     */
    private void print() {
        for (int x = 0; x < 9; x++) {
            for (int y = 0; y < 9; y++) {
                System.out.print(grid[x][y] + " ");
            }
            System.out.println("");
        }
    }

    /**
     * Generates a 9 X 9 sudoku puzzle that meets the requirements of a valid
     * sudoku grid, then prints the puzzle
     */
    public void generate() {
        boolean notValid = true;
        // In case the puzzle is invalid, the method tries again until valid
        while (notValid) {
            try {
                for (int i = 0; i <= 6; i += 3) {
                    fillThreeGrids(i, 0);
                }
                notValid = false;
            } catch (ArrayIndexOutOfBoundsException e) {
                reset();
            }
        }
        print();
    }

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        SudokuGenerator sg = new SudokuGenerator();
        for (int i = 0; i < 10; i++) {
            sg.generate();
            System.out.println("");
        }
    }
}
