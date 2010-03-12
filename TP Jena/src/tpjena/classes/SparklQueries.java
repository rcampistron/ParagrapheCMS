package tpjena.classes;


import java.io.InputStream;

import com.hp.hpl.jena.query.*;
import com.hp.hpl.jena.rdf.model.Model;
import com.hp.hpl.jena.rdf.model.ModelFactory;
import com.hp.hpl.jena.util.FileManager;

public class SparklQueries {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		
		// TODO Auto-generated method stub
		
		InputStream in = FileManager.get().open("D:/Mes documents/Psm/Master2/ubimedia/rcampistron/monProfil.rdf");
		if (in == null) { 
		  throw new IllegalArgumentException("File not found"); 
		} 
		
		Model monModel = ModelFactory.createDefaultModel();
		monModel.read(in, "");
		
		
		String queryString = "BASE <file:/D:/Mes%20documents/Psm/Master2/ubimedia/rcampistron/>" +
				"		PREFIX foaf: <http://xmlns.com/foaf/0.1/>" +
				"			SELECT ?name" +
				"			FROM <monProfil.rdf>" +
				"			WHERE { " +
				"			?Person foaf:name ?name." +
				"			}";
			
				

		Query maRequete = QueryFactory.create(queryString); 
		QueryExecution qe = QueryExecutionFactory.create(maRequete, monModel); 
		ResultSet mesResultats = qe.execSelect(); 
		ResultSetFormatter.out(System.out, mesResultats, maRequete); 
		qe.close();
		
	}
}

