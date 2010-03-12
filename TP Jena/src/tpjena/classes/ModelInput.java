package tpjena.classes;

import java.io.InputStream; 
import com.hp.hpl.jena.rdf.model.Model;
import com.hp.hpl.jena.rdf.model.ModelFactory;
import com.hp.hpl.jena.util.FileManager; 

public class ModelInput {
	
	
	
	public static void main(String[] args) {
		
	
	InputStream in = FileManager.get().open("D:/Mes documents/Psm/Master2/ubimedia/rcampistron/monProfil.rdf");
	if (in == null) { 
	  throw new IllegalArgumentException("File not found"); 
	} 
	
	Model monModel = ModelFactory.createDefaultModel();
	monModel.read(in, "");
	monModel.write(System.out, "N3");

	
	}
}
	
