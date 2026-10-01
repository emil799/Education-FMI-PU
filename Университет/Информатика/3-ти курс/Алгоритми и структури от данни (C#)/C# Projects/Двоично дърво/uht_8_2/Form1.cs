using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace trees
{
    public partial class Form1 : Form
    {
        const int in_left = 0;
        const int in_right = 1;

        public class TNode
        {
            private String data;
            public TNode left_n = null;
            public TNode right_n = null;
            // public List<TNode> nbr = null;

            public TNode() {}
            public TNode(String v) 
            {
                data = v;
            }
            public String Value
            {
               get { return data; }
               set { data = value; }
            }
            public TNode LeftTree
            {
                get { return left_n; }
                set { left_n = LeftTree; }
            }
            public TNode RightTree
            {
                get { return right_n; }
                set { right_n = RightTree; }
            }
        }
        
        public class TTree
        {
            public TNode root = null;
            private TextBox tbOut; 

            public TTree (TextBox tb) 
            {
                tbOut = tb;
            }
            public TTree (TNode v, TextBox tb)
            {
                root = v;
                tbOut = tb;
            }

            public void SearchTree()
            {
                SearchTreeN(root, 1);
            }

            private bool TreeNodeIsLeaf(TNode node)
            {
                if (node == null) return true;
                if (node.left_n == null && node.right_n == null) return true;
                return false;
            }
            
            private void DoSomethingWithNodeValue(String val, int level)
            {
                for (int i = 0; i < level; i++) tbOut.AppendText("     ");
                tbOut.AppendText(val + Environment.NewLine);
            }

            private void SearchTreeN(TNode v, int level)
            {
                if (v == null) return;

                // preorder
               
                DoSomethingWithNodeValue(v.Value, level);
                SearchTreeN(v.LeftTree, level + 1);
                SearchTreeN(v.RightTree, level + 1);
               
              // inorder 
              /*
                SearchTreeN(v.LeftTree, level + 1);
                DoSomethingWithNodeValue(v.Value, level);
                SearchTreeN(v.RightTree, level + 1);
               */
              /* 
                // postorder
                SearchTreeN(v.LeftTree, level + 1);
                SearchTreeN(v.RightTree, level + 1);
                DoSomethingWithNodeValue(v.Value, level);
              */ 
            }

            public void GenExpression(TNode v, TextBox tbOut)
            {
                if (v == null) return;

                if (!TreeNodeIsLeaf(v.LeftTree)) tbOut.AppendText("(");
                GenExpression(v.LeftTree, tbOut);
                if (!TreeNodeIsLeaf(v.LeftTree)) tbOut.AppendText(")");

                tbOut.AppendText(v.Value.ToString());

                if (!TreeNodeIsLeaf(v.RightTree)) tbOut.AppendText("(");
                GenExpression(v.RightTree, tbOut);
                if (!TreeNodeIsLeaf(v.RightTree)) tbOut.AppendText(")");
            }

            public double TreeValue(TNode v)
            {
                if (v.Value != "*" && v.Value != "+" &&
                    v.Value != "-" && v.Value != "/") return double.Parse(v.Value);

                double left_value = TreeValue(v.LeftTree);
                double right_value = TreeValue(v.RightTree);

                if (v.Value == "*")
                    return left_value * right_value;
                if (v.Value == "-")
                    return left_value - right_value;
                if (v.Value == "+")
                    return left_value + right_value;
                if (v.Value == "/")
                    return left_value / right_value;
                return 0;
            }

            private TNode SearchNode(TNode node, String val)
            {
                if (node == null) return null;

                if (node.Value == val) return node;

                TNode tmp = SearchNode(node.LeftTree, val);
                if (tmp != null) return tmp;
                return SearchNode(node.RightTree, val);
            }

            public void AddNode(String par, int dir, String val)
            {
                if (root == null)
                {
                    root = new TNode(val);
                    return;
                }
                TNode node = SearchNode(root, par);
                if (node == null) return;

                if (dir == in_left)
                {
                    if (node.LeftTree == null)
                        node.left_n = new TNode(val);
                }
                else if (dir == in_right)
                {
                    if (node.right_n == null)
                        node.right_n = new TNode(val);
                }
            }
        }

        public Form1()
        {
            InitializeComponent();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            TTree my_tree = new TTree(textBox1);
                                              
                       my_tree.AddNode("", -1, "1");
                       my_tree.AddNode("1", in_left, "2");
                       my_tree.AddNode("1", in_right, "3");
                       my_tree.AddNode("2", in_left, "4");
                       my_tree.AddNode("2", in_right, "5");
                       my_tree.AddNode("3", in_left, "6");
                       my_tree.AddNode("3", in_right, "7");
                     

                       my_tree.SearchTree();
            

            return;        
     
          /*
            my_tree.AddNode("", -1, "*");
            my_tree.AddNode("*", in_left, "-");
            my_tree.AddNode("*", in_right, "+");
            my_tree.AddNode("-", in_left, "6");
            my_tree.AddNode("-", in_right, "4");
            my_tree.AddNode("+", in_left, "3");
            my_tree.AddNode("+", in_right, "45");

            my_tree.SearchTree();
            
            textBox1.AppendText(Environment.NewLine);

            my_tree.GenExpression(my_tree.root, textBox1);

            textBox1.AppendText(Environment.NewLine);

            textBox1.AppendText(my_tree.TreeValue(my_tree.root).ToString());
            */

        }
    }
}
