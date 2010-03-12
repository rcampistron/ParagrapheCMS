package tpjena.classes;



import com.hp.hpl.jena.rdf.model.Model;
import com.hp.hpl.jena.rdf.model.ModelFactory;
import com.hp.hpl.jena.rdf.model.Resource;
import com.hp.hpl.jena.vocabulary.VCARD;


public class ModelCreation {

	

public static void main(String[] args) {
	
	
	Model monModel = ModelFactory.createDefaultModel(); 
	
	Resource maRessource = monModel.createResource("D:/Mes documents/Psm/Master 2/ubimedia/rcampistron");
	
	maRessource.addProperty(VCARD.FN, "Campistron Rémi"); 
	monModel.write(System.out, "RDF/XML"); 
	
	
	
	}
}


