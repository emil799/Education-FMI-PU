using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_5
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
            textBox1.Text = "10";
            textBox2.Text = "2";
        }
        
        private string ReverseStr(string s1)
        {
            string res = "";
            for (int i = s1.Length - 1; i >= 0; i--)
                res += s1[i];
            return res;
        }

        private string ConvertFrom10(string num, int b)
        {
            long n = Int64.Parse(num); 
            string result = "";
            long mod;
            int rest;
            char ch;

            do {
                mod = n / b;
                rest = (int)(n % b);

                if (rest < 10)
                    result += rest.ToString();
                else
                {
                    ch = (char)('a' + (rest - 10));
                    result += ch;
                }
                n = mod;
            } 
            while (mod > 0);

            return ReverseStr(result);  // result.Reverse ??
        }

        private string ConvertTo10(string num, int p)
        {
            long res = 0;
            int v;

            res = 0;

            foreach(char n in num)
            {
                if (n >= 'a')
                    v = (n - 'a') + 10;
                else
                    v = (n - '0');

                res = res * p  + v;
            }
            //res /= p;

            return res.ToString();
        }

        private void WriteRes(string n1, int b1, string n2, int b2)
        {
            textBox4.AppendText(
                n1 + "(" + b1 + ")" + " = " +
                n2 + "(" + b2 + ")" + Environment.NewLine);
        }

        private void button1_Click(object sender, EventArgs e)
        {
            int base1 = int.Parse(textBox1.Text);
            int base2 = int.Parse(textBox2.Text);

            string num = textBox3.Text;

            if (base1 == base2)
            {
                WriteRes(num, base1, num, base2);
            }
            else if (base1 == 10)
            {
                WriteRes(num, base1, ConvertFrom10(num, base2), base2);
            }
            else if (base2 == 10)
            {
                WriteRes(num, base1, ConvertTo10(num, base1), base2);
            }
            else
            {
                string num10 = ConvertTo10(num, base1);
                WriteRes(num, base1, ConvertFrom10(num10, base2), base2);
            }        
        }

        private void button2_Click(object sender, EventArgs e)
        {
            int[] val = new int[] {
                1, 4, 5, 9, 10, 40, 50, 90, 100, 400, 500, 900, 1000
            };
            string[] pic = new string[] {
                "I", "IV", "V", "IX", "X", "XL", "L", "XC", "C",
                "CD", "D", "CM", "M"
            };

            int i = val.Length - 1;

            int n, q;

            n = int.Parse(textBox3.Text);
            
            while (n > 0)
            {
                q = n / val[i];
                n = n % val[i];
                for(int k=1; k<=q; k++)
                {
                    textBox4.AppendText(pic[i]);
                }
                i--;
            }
            textBox4.AppendText(Environment.NewLine);
        }

        private void label2_Click(object sender, EventArgs e)
        {

        }
    }
}
