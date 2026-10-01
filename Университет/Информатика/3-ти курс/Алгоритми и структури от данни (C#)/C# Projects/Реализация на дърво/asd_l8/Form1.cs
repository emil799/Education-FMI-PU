using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace asd_l8
{
    public partial class Form1 : Form
    {
        const int in_left = 0;
        const int in_right = 1;

        public class TNode
        {
            private int _value;
            public TNode _leftSTree;
            public TNode _rightSTree;

            public TNode()
            {
                _value = -1;
                _leftSTree = _rightSTree = null;
            }
            public TNode(int data)
            {
                _value = data;
                _leftSTree = _rightSTree = null;
            }

            public int Value
            {
                get
                {
                    return _value;
                }
                set
                {
                    _value = value;
                }
            }

        }                

        public class TTree
        {
            public TNode _root;

            public TTree()
            {
                _root = null;
            }
            public TTree(TNode fnode)
            {
                _root = fnode;
            }

            public void DisplayTree(TextBox tbOut)
            {
                SearchTree(tbOut, _root, 0);
            }

            private void SearchTree(TextBox tbOut, TNode fn, int level)
            {
                if (fn == null) return;

                for (int k = 0; k < level; k++)
                    tbOut.AppendText("        ");
                tbOut.AppendText(fn.Value.ToString() + Environment.NewLine);
                
                SearchTree(tbOut, fn._leftSTree, level + 1);

                SearchTree(tbOut, fn._rightSTree, level + 1);
            }

            public TNode SearchNode(TNode fn, int val)
            {
                if (fn == null) return null;

                if (fn.Value == val) return fn;

                TNode left_search_res = SearchNode(fn._leftSTree, val);
                TNode right_search_res = SearchNode(fn._rightSTree, val);

                if (left_search_res != null) return left_search_res;
                return right_search_res;
            }

            public TNode SearchNodeP(TNode fn, int val)
            {
                if (fn == null) return null;

                if (fn._leftSTree != null && fn._leftSTree.Value == val) return fn;
                if (fn._rightSTree != null && fn._leftSTree.Value == val) return fn;

                if (SearchNodeP(fn._leftSTree, val) != null)
                    return SearchNodeP(fn._leftSTree, val);
                return SearchNodeP(fn._rightSTree, val);
            }

            public void AddNode(int pval, int dir, int new_val)
            {
                TNode new_node = new TNode(new_val);

                if (_root == null || pval == -1 )
                {
                    _root = new_node; return;
                }
                TNode par = SearchNode(_root, pval);
                
                if (par == null) return;
                if (dir == in_left)
                    par._leftSTree = new_node;
                else if (dir == in_right)
                    par._rightSTree = new_node;
            }

            public void Clear()
            {
                _root = null;
            }

            public void DeleteNodeTree(int val)
            {
                if (_root.Value == val)
                {
                    _root = null; return;
                } 

                TNode t = SearchNodeP(_root, val);

                if (t._leftSTree != null && t._leftSTree.Value == val)
                    t._leftSTree = null;

                if (t._rightSTree != null && t._rightSTree.Value == val)
                    t._rightSTree = null;
            }


        }

        TTree my_tree;

        public Form1()
        {
            InitializeComponent();
            my_tree = new TTree();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            my_tree.AddNode(-1, -1, 1);
            my_tree.AddNode(1, in_left, 2);
            my_tree.AddNode(1, in_right, 3);
            my_tree.AddNode(3, in_left, 5);
            my_tree.AddNode(3, in_right, 6);
            my_tree.AddNode(5, in_left, 7);
            my_tree.AddNode(5, in_right, 8);
            
             
  //          my_tree.DeleteNodeTree(5);

            my_tree.DisplayTree(textBox1);
        }
    }
}
