	import java.awt.Color;
	import java.awt.Dimension;
	import java.awt.GridLayout;
	import java.awt.Image;
	import java.awt.MenuBar;
	import java.awt.MenuComponent;
	import java.awt.Rectangle;
	import java.awt.Shape;
	import java.awt.event.ActionEvent;
	import java.awt.event.ActionListener;
	import java.awt.event.MouseEvent;
	import java.awt.event.MouseListener;
	import java.sql.Connection;
	import java.sql.PreparedStatement;
	import java.sql.ResultSet;
	import java.sql.SQLException;
	
	import javax.swing.JButton;
	import javax.swing.JComboBox;
	import javax.swing.JFrame;
	import javax.swing.JLabel;
	import javax.swing.JPanel;
	import javax.swing.JScrollPane;
	import javax.swing.JTabbedPane;
	import javax.swing.JTable;
	import javax.swing.JTextField;
	
	
	
	import java.awt.event.*;
	
	public class NewFrame extends JFrame {
		Connection conn = null;
		PreparedStatement state = null;
		ResultSet result = null;
		int id = -1;
		
		JTabbedPane tab=new JTabbedPane();
		
		JPanel personP = new JPanel();
		JPanel carP = new JPanel();
		JPanel rentaP = new JPanel();
		JPanel spravka1Panel = new JPanel();
		JPanel spravka2Panel = new JPanel();
	
		//Person
		JTable personTable= new JTable();
		JScrollPane personScroll = new JScrollPane(personTable);
		
		JPanel topPersonP = new JPanel(); // Тук разделяме на три части панела и така трябва да се направи всеки от	панелите без последния - sprP
		JPanel midPersonP = new JPanel();
		JPanel downPersonP = new JPanel();
	
		JLabel namePersonL = new JLabel("Име:");
		JLabel telPersonL = new JLabel("Телефон:");
		JLabel egnPersonL = new JLabel("ЕГН:");
		
		JTextField namePersonTF = new JTextField();
		JTextField telPersonTF = new JTextField();
		JTextField egnPersonTF = new JTextField();
	
		JButton personAdd = new JButton("Добавяне");
		JButton personDel = new JButton("Изтриване");
		JButton personEdit = new JButton("Редактиране");
		JButton personSearch = new JButton("Търсене по ЕГН");
		JButton personRefresh = new JButton("Обнови");

		//Car
		JTable carTable= new JTable();
		JScrollPane carScroll = new JScrollPane(carTable);
		
		JPanel carTopPanel = new JPanel();
		JPanel carMidPanel = new JPanel();
		JPanel carDownPanel = new JPanel();
		
		JLabel markaCarL = new JLabel("Марка:");
		JLabel nomerCarL = new JLabel("Номер:");
		JLabel yearCarL = new JLabel("Година:");
		
		JTextField markaCarTF = new JTextField();
		JTextField nomerCarTF = new JTextField();
		JTextField yearCarTF = new JTextField();
		
		JButton carAdd = new JButton("Добавяне");
		JButton carDel = new JButton("Изтриване");
		JButton carEdit = new JButton("Редактиране");
		JButton carSearch = new JButton("Търсене по марка");
		JButton carRefresh = new JButton("Обнови");
		
		
		//Renta
		JTable rentaTable= new JTable();
		JScrollPane rentaScroll = new JScrollPane(rentaTable);
		
		JPanel rentaTopPanel = new JPanel();
		JPanel rentaMidPanel = new JPanel();
		JPanel rentaDownPanel = new JPanel();
		
		JLabel personRentaL = new JLabel("Човек:");
		JLabel carRentaL = new JLabel("Кола:");
		JLabel dateRentaL = new JLabel("Дата:");
		JLabel cenaRentaL = new JLabel("Цена:");
		
		JComboBox<String> comboPerson = new JComboBox<String>();
		JComboBox<String> comboCar = new JComboBox<String>();
		JTextField dateRentaTF = new JTextField();
		JTextField cenaRentaTF = new JTextField();
		
		JButton rentaAdd = new JButton("Добавяне");
		JButton rentaDel = new JButton("Изтриване");
		JButton rentaEdit = new JButton("Редактиране");
		JButton rentaSearch = new JButton("Търсене по човек");
		JButton rentaRefresh = new JButton("Обнови");
		
		//Spravka1
		JTable spravka1Table= new JTable();
		JScrollPane spravka1Scroll = new JScrollPane(spravka1Table);
		
		JPanel spravka1TopPanel = new JPanel();
		JPanel spravka1MidPanel = new JPanel();
		JPanel spravka1DownPanel = new JPanel();
		
		JLabel kr1Spravka1L = new JLabel("Име:");
		JLabel kr2Spravka1L = new JLabel("Марка на кола:");
		
		JTextField kr1Spravka1TF = new JTextField();
		JTextField kr2Spravka1TF = new JTextField();
		
		JButton showSpravka1 = new JButton("Покажи справка");
		
		//Spravka2
		JTable spravka2Table= new JTable();
		JScrollPane spravka2Scroll = new JScrollPane(spravka2Table);
		JPanel spravka2TopPanel = new JPanel();
		JPanel spravka2MidPanel = new JPanel();
		JPanel spravka2DownPanel = new JPanel();
		
		JLabel kr1Spravka2L = new JLabel("Година:");
		JLabel kr2Spravka2L = new JLabel("Телефон:");
		
		JTextField kr1Spravka2TF = new JTextField();
		JTextField kr2Spravka2TF = new JTextField();
		
		JButton showSpravka2 = new JButton("Покажи справка");
		
		

	public NewFrame() {
		this.setSize(400,600);
		this.setDefaultCloseOperation(EXIT_ON_CLOSE);
		
		tab.add("Клиенти", personP);		
		tab.add("Коли", carP);
		tab.add("Наем", rentaP);
		tab.add("Справка по име и марка на кола", spravka1Panel);
		tab.add("Справка по година и телефон", spravka2Panel);
		this.add(tab);
		
		//Person
		personP.setLayout(new GridLayout(3,1));
				
		topPersonP.setLayout(new GridLayout(3, 2));
		topPersonP.add(namePersonL);
		topPersonP.add(namePersonTF);
		topPersonP.add(telPersonL);
		topPersonP.add(telPersonTF);
		topPersonP.add(egnPersonL);
		topPersonP.add(egnPersonTF);
				
		midPersonP.add(personAdd);
		midPersonP.add(personDel);
		midPersonP.add(personEdit);
		midPersonP.add(personSearch);
		midPersonP.add(personRefresh);
				
		personScroll.setPreferredSize(new Dimension(450, 130));
		downPersonP.add(personScroll);
				
		personP.add(topPersonP);
		personP.add(midPersonP);
		personP.add(downPersonP);
				
		personTable.addMouseListener(new MouseActionPerson());
				
		personAdd.addActionListener(new AddActionPerson());
		personDel.addActionListener(new DeleteActionPerson());
		personEdit.addActionListener(new UpdateActionPerson());
		personSearch.addActionListener(new SearchActionPerson());
		personRefresh.addActionListener(new RefreshActionPerson());
		refreshTable("person", personTable);
				
		//Car
		carP.setLayout(new GridLayout(3,1));
				
		carTopPanel.setLayout(new GridLayout(3, 2));
		carTopPanel.add(markaCarL);
		carTopPanel.add(markaCarTF);
		carTopPanel.add(nomerCarL);
		carTopPanel.add(nomerCarTF);
		carTopPanel.add(yearCarL);
		carTopPanel.add(yearCarTF);
				
		carMidPanel.add(carAdd);
		carMidPanel.add(carDel);
		carMidPanel.add(carEdit);
		carMidPanel.add(carSearch);
		carMidPanel.add(carRefresh);
				
		carScroll.setPreferredSize(new Dimension(450, 130));
		carDownPanel.add(carScroll);
				
		carP.add(carTopPanel);
		carP.add(carMidPanel);
		carP.add(carDownPanel);
				
		carTable.addMouseListener(new MouseActionCar());
				
		carAdd.addActionListener(new AddActionCar());
		carDel.addActionListener(new DeleteActionCar());
		carEdit.addActionListener(new UpdateActionCar());
		carSearch.addActionListener(new SearchActionCar());
		carRefresh.addActionListener(new RefreshActionCar());
		refreshTable("car", carTable);
		
		//Renta
		rentaP.setLayout(new GridLayout(3,1));
				
		rentaTopPanel.setLayout(new GridLayout(4, 2));
		rentaTopPanel.add(personRentaL);
		rentaTopPanel.add(comboPerson);
		rentaTopPanel.add(carRentaL);
		rentaTopPanel.add(comboCar);
		rentaTopPanel.add(dateRentaL);
		rentaTopPanel.add(dateRentaTF);
		rentaTopPanel.add(cenaRentaL);
		rentaTopPanel.add(cenaRentaTF);
				
		rentaMidPanel.add(rentaAdd);
		rentaMidPanel.add(rentaDel);
		rentaMidPanel.add(rentaEdit);
		//rentaMidPanel.add(rentaSearch);
		//rentaMidPanel.add(rentaRefresh);
				
		rentaScroll.setPreferredSize(new Dimension(450, 130));
		rentaDownPanel.add(rentaScroll);
				
		rentaP.add(rentaTopPanel);
		rentaP.add(rentaMidPanel);
		rentaP.add(rentaDownPanel);
				
		rentaAdd.addActionListener(new AddActionRenta());
		rentaTable.addMouseListener(new MouseActionRenta());
		rentaDel.addActionListener(new DeleteActionRenta());
		rentaEdit.addActionListener(new UpdateActionRenta());
				
	    refreshComboPerson();
		refreshComboCar ();
		refreshTableRenta();
				
		
		//Spravka1
		spravka1Panel.setLayout(new GridLayout(3,1));
				
		spravka1TopPanel.setLayout(new GridLayout(2, 2));
		spravka1TopPanel.add(kr1Spravka1L);
		spravka1TopPanel.add(kr1Spravka1TF);
		spravka1TopPanel.add(kr2Spravka1L);
		spravka1TopPanel.add(kr2Spravka1TF);
				
		spravka1MidPanel.add(showSpravka1);
				
		spravka1Scroll.setPreferredSize(new Dimension(450, 130));
		spravka1DownPanel.add(spravka1Scroll);
				
		spravka1Panel.add(spravka1TopPanel);
		spravka1Panel.add(spravka1MidPanel);
		spravka1Panel.add(spravka1DownPanel);

		showSpravka1.addActionListener(new ActionSpravka1());
				
				
		//Spravka2
				
		spravka2Panel.setLayout(new GridLayout(3,1));
				
		spravka2TopPanel.setLayout(new GridLayout(2, 2));
		spravka2TopPanel.add(kr1Spravka2L);
		spravka2TopPanel.add(kr1Spravka2TF);
		spravka2TopPanel.add(kr2Spravka2L);
		spravka2TopPanel.add(kr2Spravka2TF);
				
		spravka2MidPanel.add(showSpravka2);
				
		spravka2Scroll.setPreferredSize(new Dimension(450, 130));
		spravka2DownPanel.add(spravka2Scroll);
				
		spravka2Panel.add(spravka2TopPanel);
		spravka2Panel.add(spravka2MidPanel);
		spravka2Panel.add(spravka2DownPanel);
				
		showSpravka2.addActionListener(new ActionSpravka2());


				
		this.setVisible(true);
} // end constructor
	
	public void refreshTable(String name,JTable table) {
		conn=DBConnection.getConnection();
		String str = "select * from " + name;
		
		try {
			state= conn.prepareStatement(str);
			result=state.executeQuery();
			table.setModel(new MyModel(result));
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void refreshTableRenta() {
		conn=DBConnection.getConnection();
		String str = "SELECT R.ID, name, marka, date, cena FROM Renta R JOIN Person P ON R.ID_persom = P.ID JOIN Car C ON R.ID_car = C.ID";
		try {
			state= conn.prepareStatement(str);
			result=state.executeQuery();
			rentaTable.setModel(new MyModel(result));
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (Exception e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	
	public void refreshComboPerson () {
		comboPerson.removeAllItems();
		
		String sql = "select id, name from person";
		conn=DBConnection.getConnection();
		String item = "";
		
		try {
			state=conn.prepareStatement(sql);
			result=state.executeQuery();
			while(result.next()) {
				item = result.getObject(1).toString()+"."+result.getObject(2).toString();
				comboPerson.addItem(item);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	public void refreshComboCar () {
		comboCar.removeAllItems();
		
		String sql = "select id, marka from car";
		conn=DBConnection.getConnection();
		String item = "";
		
		try {
			state=conn.prepareStatement(sql);
			result=state.executeQuery();
			while(result.next()) {
				item = result.getObject(1).toString()+"."+result.getObject(2).toString();
				comboCar.addItem(item);
			}
		} catch (SQLException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
	class AddActionPerson implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn = DBConnection.getConnection();
			String sql = "insert into person(name, telefon, egn) values(?,?,?)";
			try {
				state= conn.prepareStatement(sql);
				state.setString(1, namePersonTF.getText());
				state.setString(2, telPersonTF.getText());
				state.setString(3, egnPersonTF.getText());
				state.execute();
				refreshTable("person", personTable);
				refreshComboPerson();
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			namePersonTF.setText("");
			telPersonTF.setText("");
			egnPersonTF.setText("");
			
		}
		
	}
	
	class DeleteActionPerson implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String sql = "delete from person where id=?";
			
			try {
				state = conn.prepareStatement(sql);
				state.setInt(1, id);
				state.execute();
				refreshTable("person", personTable);
				id = -1;
				refreshComboPerson();
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			namePersonTF.setText("");
			telPersonTF.setText("");
			egnPersonTF.setText("");
			
			
		}
		
	}
	
	class UpdateActionPerson implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn= DBConnection.getConnection();
			String sql = "update person set  name=? , telefon=?, egn=? where id=?";	
			
			try {
				state= conn.prepareStatement(sql);
				state.setString(1, namePersonTF.getText());
				state.setString(2, telPersonTF.getText());
				state.setString(3, egnPersonTF.getText());
				state.setInt(4, id);
				state.execute();
				refreshTable("person", personTable);
				id=-1;
				refreshComboPerson();
				refreshTableRenta();
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			namePersonTF.setText("");
			telPersonTF.setText("");
			egnPersonTF.setText("");
			
			
		}
		
		
	}
	
	class SearchActionPerson implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String str = "select * from Person where egn=?";
			
			try {
				state= conn.prepareStatement(str);
				state.setString(1, egnPersonTF.getText());
				result=state.executeQuery();
				personTable.setModel(new MyModel(result));
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			} catch (Exception e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
		}
		
	}

	
	class RefreshActionPerson implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			refreshTable("person", personTable);
			
		}
		
	}
	
	class MouseActionPerson implements MouseListener {

		@Override
		public void mouseClicked(MouseEvent e) {
			int row = personTable.getSelectedRow();
			id = Integer.parseInt(personTable.getValueAt(row, 0).toString());
			
			namePersonTF.setText(personTable.getValueAt(row, 1).toString());
			telPersonTF.setText(personTable.getValueAt(row, 2).toString());
			egnPersonTF.setText(personTable.getValueAt(row, 3).toString());
		}

		@Override
		public void mousePressed(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseReleased(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseEntered(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseExited(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}
		
	}
	class MouseActionCar implements MouseListener {

		@Override
		public void mouseClicked(MouseEvent e) {
			int row = carTable.getSelectedRow();
			id = Integer.parseInt(carTable.getValueAt(row, 0).toString());
			
			markaCarTF.setText(carTable.getValueAt(row, 1).toString());
			nomerCarTF.setText(carTable.getValueAt(row, 2).toString());
			yearCarTF.setText(carTable.getValueAt(row, 3).toString());
			
		}

		@Override
		public void mousePressed(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseReleased(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseEntered(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseExited(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}
		
	}
	
	class AddActionCar implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn = DBConnection.getConnection();
			String sql = "insert into car(marka, nomer, year_) values(?,?,?)";
			try {
				state= conn.prepareStatement(sql);
				state.setString(1, markaCarTF.getText());
				state.setString(2, nomerCarTF.getText());
				state.setString(3, yearCarTF.getText());
				state.execute();
				refreshTable("car", carTable);
				refreshComboCar ();
			} catch (SQLException e1) { 
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			markaCarTF.setText("");
			nomerCarTF.setText("");
			yearCarTF.setText("");
		}
		
	}
	
	
	class DeleteActionCar implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String sql = "delete from car where id=?";
			
			try {
				state = conn.prepareStatement(sql);
				state.setInt(1, id);
				state.execute();
				refreshTable("car", carTable);
				id = -1;
				refreshComboCar ();
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			markaCarTF.setText("");
			nomerCarTF.setText("");
			yearCarTF.setText("");
			
		}
		
	}
	
	class UpdateActionCar implements ActionListener{

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String sql="update car set marka=?, nomer=?, year_=? where id=?";
			
			try {
				state=conn.prepareStatement(sql);
				state.setString(1, markaCarTF.getText());
				state.setString(2, nomerCarTF.getText());
				state.setString(3, yearCarTF.getText());
				state.setInt(4, id);
				state.execute();
				refreshTable("car", carTable);
				id=-1;
				refreshComboCar();
				refreshTableRenta();
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			markaCarTF.setText("");
			nomerCarTF.setText("");
			yearCarTF.setText("");
			
		}
		
	}
	class SearchActionCar implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String str = "select * from Car where marka=?";
			
			try {
				state= conn.prepareStatement(str);
				state.setString(1, markaCarTF.getText());
				result=state.executeQuery();
				carTable.setModel(new MyModel(result));
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			} catch (Exception e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
		}
		
	}
	class RefreshActionCar implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			// TODO Auto-generated method stub
			refreshTable("car", carTable);
			
		}
		
	}
	
	class MouseActionRenta implements MouseListener {

		@Override
		public void mouseClicked(MouseEvent e) {
			int row = rentaTable.getSelectedRow();
			id = Integer.parseInt(rentaTable.getValueAt(row, 0).toString());
			
			dateRentaTF.setText(rentaTable.getValueAt(row, 3).toString());
			cenaRentaTF.setText(rentaTable.getValueAt(row, 4).toString());
			
		}

		@Override
		public void mousePressed(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseReleased(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseEntered(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}

		@Override
		public void mouseExited(MouseEvent e) {
			// TODO Auto-generated method stub
			
		}
		
	}
	
	class AddActionRenta implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			String itemPersonCombo=comboPerson.getSelectedItem().toString();
			String itemCarCombo=comboCar.getSelectedItem().toString();
			conn = DBConnection.getConnection();
			String sql = "insert into renta(id_persom, id_car, date, cena) values(?,?,?,?)";
			try {
				state= conn.prepareStatement(sql);
				state.setInt(1, Integer.parseInt(itemPersonCombo.substring(0, itemPersonCombo.indexOf('.'))));
				state.setInt(2,Integer.parseInt(itemCarCombo.substring(0, itemCarCombo.indexOf('.'))));
				state.setString(3, dateRentaTF.getText());
				state.setDouble(4, Double.parseDouble(cenaRentaTF.getText()));
				state.execute();
				refreshTableRenta();
				System.out.println("Teodora");
			} catch (SQLException e1) { 
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			dateRentaTF.setText("");
			cenaRentaTF.setText("");
		}
	}
	class DeleteActionRenta implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String sql = "delete from renta where id=?";
			
			try {
				state = conn.prepareStatement(sql);
				state.setInt(1, id);
				state.execute();
				refreshTableRenta();
				id = -1;
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			
			dateRentaTF.setText("");
			cenaRentaTF.setText("");
		}
		
	}
	class UpdateActionRenta implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			String itemPersonCombo=comboPerson.getSelectedItem().toString();
			String itemCarCombo=comboCar.getSelectedItem().toString();
			conn= DBConnection.getConnection();
			String sql = "update renta set  id_persom=? , id_car=?, date=? , cena=? where id=?";	
			
			try {
				state= conn.prepareStatement(sql);
				state.setInt(1, Integer.parseInt(itemPersonCombo.substring(0, itemPersonCombo.indexOf('.'))));
				state.setInt(2,Integer.parseInt(itemCarCombo.substring(0, itemCarCombo.indexOf('.'))));
				state.setString(3, dateRentaTF.getText());
				state.setDouble(4, Double.parseDouble(cenaRentaTF.getText()));
				state.setInt(5, id);
				state.execute();
				refreshTableRenta();
				id=-1;
			} catch (SQLException e1) {
				// TODO Auto-generated catch block
				e1.printStackTrace();
			}
			dateRentaTF.setText("");
			cenaRentaTF.setText("");
		}
	}
	
	class ActionSpravka1 implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String sql = "SELECT Name, marka, date, cena FROM Renta R JOIN Person P ON R.ID_persom = P.ID JOIN Car C ON R.ID_car = C.ID WHERE Name = ? And marka = ?";
			
			try {
				state=conn.prepareStatement(sql);
				state.setString(1, kr1Spravka1TF.getText());
				state.setString(2, kr2Spravka1TF.getText());
				result=state.executeQuery();
				spravka1Table.setModel(new MyModel(result));
				
			}catch (Exception e1) {
				e1.printStackTrace();
			}
			kr1Spravka1TF.setText("");
			kr2Spravka1TF.setText("");
		}
	}
	class ActionSpravka2 implements ActionListener {

		@Override
		public void actionPerformed(ActionEvent e) {
			conn=DBConnection.getConnection();
			String sql = "SELECT Name, marka, date, cena FROM Renta R JOIN Person P ON R.ID_persom = P.ID JOIN Car C ON R.ID_car = C.ID WHERE year_ = ? AND telefon = ?";
			
			try {
				state=conn.prepareStatement(sql);
				state.setInt(1, Integer.parseInt(kr1Spravka2TF.getText()));
				state.setString(2, kr2Spravka2TF.getText());
				result=state.executeQuery();
				spravka2Table.setModel(new MyModel(result));
				
			}catch (Exception e1) {
				e1.printStackTrace();
			}
			kr1Spravka2TF.setText("");
			kr2Spravka2TF.setText("");
		}
	}
}// end NewFrame