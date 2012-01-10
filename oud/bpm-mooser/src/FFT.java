package src;

public class FFT {


    static void SWAP(float data[], int i, int j) {
        float temp;

        temp = data[i];
        data[i] = data[j];
        data[j] = temp;
    }


    static float[] DoRealFFT(float datain[], int start, int len)
    {
        int i;

        float data[] = new float[len*2];
        for(i=0; i<len; i++)
        {
            data[2*i] = datain[start+i];
            data[2*i+1] = 0.0f;
        }

        return DoFFT(data, 1);

    }

    static float[] DoIFFT(float datain[])
    {
        int i, n;
        float retval[] = DoFFT(datain, -1);
        n=retval.length;
        for(i=0; i<n; i++)
            retval[i] = 2*retval[i]/n;

        return retval;
    }

    static float[] DoFFT(float datain[], int isign)
    /*Replaces data[1..2*nn] by its discrete Fourier transform, if isign is input as 1; or replaces
         data[1..2*nn] by nn times its inverse discrete Fourier transform, if isign is input as \u22121.
         data is a complex array of length nn or, equivalently, a real array of length 2*nn. nn MUST
         be an integer power of 2 (this is not checked for!).*/
    {

        int n = datain.length;
        float data[] = new float[n];
        int  mmax, m, j, istep, i;
        double wtemp, wr, wpr, wpi, wi, theta;
        double tempr, tempi;

        j = 0;

        // This is the bit-reversal section of the routine.
        for (i = 0; i < n-1; i += 2) {
            if (j >= i) {
                //SWAP(data, j, i);
                data[j] = datain[i];
                data[i] = datain[j];
                //Exchange the two complex numbers.
                //SWAP(data, j + 1, i + 1);
                data[j+1] = datain[i+1];
                data[i+1] = datain[j+1];
            }
            m = n/2;
            while (m >= 2 && j >= m) {
                j -= m;
                m = m/2;
            }

            j += m;
        }

        //Here begins the Danielson - Lanczos section of the routine.
        mmax = 2;
        //Outer loop executed log2 nn times.
        while (n > mmax) {
            istep = mmax *2;
            //Initialize the trigonometric recurrence.
            theta = isign * (2 * Math.PI / mmax);
            wpr = Math.cos(theta);

            wpi = Math.sin(theta);
            wr = 1.0;
            wi = 0.0;
            //Here are the two nested inner loops.
            for (m = 0; m < mmax-1; m += 2) {
                for (i = m; i < n-2; i += istep) {
                    //This is the Danielson-Lanczos formula:
                    j = i + mmax;
                    tempr = wr * data[j] - wi * data[j + 1];
                    tempi = wr * data[j + 1] + wi * data[j];
                    data[j] = data[i] - (float)tempr;
                    data[j + 1] = data[i + 1] - (float)tempi;
                    data[i] += tempr;
                    data[i + 1] += tempi;
                }
                //Trigonometric recurrence.
                wr = (wtemp = wr) * wpr - wi * wpi;
                wi = wi * wpr + wtemp * wpi;
            }
            mmax = istep;
        }

        return data;
    }

};
