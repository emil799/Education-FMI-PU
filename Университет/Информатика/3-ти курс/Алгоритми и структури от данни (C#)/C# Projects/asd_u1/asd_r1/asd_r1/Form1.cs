using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_r1
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            byte a;

            a = 5;

            textBox1.AppendText(a.ToString() + '\n' );
            textBox1.AppendText(Environment.NewLine);
            textBox1.AppendText("text");

            float r = 255;

            a = (byte)r;

            a = (byte)(r + 2);
            textBox1.AppendText(Environment.NewLine);
            textBox1.AppendText(a.ToString());
        }
    }
}
