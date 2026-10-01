using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace uht_9
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        const string empty_str = "                                              ";

        private void button1_Click(object sender, EventArgs e)
        {
            System.IO.DriveInfo di = new System.IO.DriveInfo(@"C:\");

            textBox2.AppendText(di.TotalFreeSpace + Environment.NewLine);
            textBox2.AppendText(di.VolumeLabel + Environment.NewLine);
            
            // Get the root directory and print out some information about it.
            System.IO.DirectoryInfo dirInfo = di.RootDirectory;
            textBox2.AppendText(dirInfo.Attributes.ToString() + Environment.NewLine + Environment.NewLine);

            // Get the files in the directory and print out some information about them.
            System.IO.FileInfo[] fileNames = dirInfo.GetFiles("*.*");
            foreach (System.IO.FileInfo fi in fileNames)
            {   
                textBox2.AppendText(fi.FullName + ": " + fi.LastAccessTime + ": " + fi.Length
                    + Environment.NewLine);
            }
            textBox2.AppendText(Environment.NewLine + Environment.NewLine);

            System.IO.DirectoryInfo[] dirInfos = dirInfo.GetDirectories("*.*");
            foreach (System.IO.DirectoryInfo d in dirInfos)
            {
                textBox2.AppendText(d.Name + Environment.NewLine);
            }
            textBox2.AppendText(Environment.NewLine + Environment.NewLine);

            // Get the current application directory.
            string currentDirName = System.IO.Directory.GetCurrentDirectory();
            textBox2.AppendText(currentDirName + Environment.NewLine);
            textBox2.AppendText(Environment.NewLine + Environment.NewLine);

            System.IO.Directory.SetCurrentDirectory(@"C:\Users");//\Public\Cards");
            currentDirName = System.IO.Directory.GetCurrentDirectory();

            string[] dNames = System.IO.Directory.GetDirectories(currentDirName);
            string[] fNames = System.IO.Directory.GetFiles(currentDirName);

            foreach (string fi in fNames)
            {
                textBox2.AppendText(fi + Environment.NewLine);
            }
        }

        private void SearchDir(System.IO.DirectoryInfo cdir, int level)
        {
            textBox2.AppendText(empty_str.Substring(1, level*2) +
                cdir.FullName + Environment.NewLine);

            level++;
            System.IO.FileInfo[] fileNames = null;
            try
            {
                fileNames = cdir.GetFiles("*.*");
            }
            catch
            {
               fileNames = null;
            }
            
            if (fileNames != null)
            {
                foreach (System.IO.FileInfo fi in fileNames)
                {
                    textBox2.AppendText(empty_str.Substring(1, level*2) +
                        fi.Name + ": " + fi.LastAccessTime + ": "
                        + fi.Length + Environment.NewLine);
                }
            }

            System.IO.DirectoryInfo[] dirInfos;
            try
            {
                dirInfos = cdir.GetDirectories("*.*");
            }
            catch
            {
                dirInfos = null;
            }
            
            if (dirInfos != null)
            {
                foreach (System.IO.DirectoryInfo d in dirInfos)
                {
                    SearchDir(d, level);
                }
            }
        }

        private void button2_Click(object sender, EventArgs e)
        {
            System.IO.DirectoryInfo cdir =
                System.IO.Directory.GetParent(@"C:");

            System.IO.DriveInfo di = new System.IO.DriveInfo(@"C:\");
            System.IO.DirectoryInfo dirInfo = di.RootDirectory;
            SearchDir(dirInfo, 1);

            //SearchDir(cdir, 1);
        }

        private void button3_Click(object sender, EventArgs e)
        {
            SearchDir2(@"C:\Users\Public", 1);
        }

        private void SearchDir2(string dir_name, int level)
        {
            textBox2.AppendText(empty_str.Substring(1, level * 2) +
                dir_name + Environment.NewLine);

            level++;
            string[] fNames;
            try
            {
                fNames = System.IO.Directory. GetFiles(dir_name);
            }
            catch
            {
                fNames = null;
            }
            if (fNames != null)
            {
                foreach (string fi in fNames)
                {
                    textBox2.AppendText(empty_str.Substring(1, level * 2) +
                        fi + Environment.NewLine);
                }
            }

            string[] dNames;
            try
            {
                dNames = System.IO.Directory.GetDirectories(dir_name);
            }
            catch
            {
                dNames = null;
            }
            if (dNames != null)
            {
                foreach (string di in dNames)
                {
                    SearchDir2(di, level);
                }
            }

        }
    }
}
