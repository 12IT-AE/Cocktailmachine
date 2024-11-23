import time
import pumpcontrol
from models import Maintenance

def executeMaintainence(job,pump_runtime=2):
        if job is None:
            print("Kein Wartungsjob übergeben. Abbruch.")
            return
        
        # Überprüfen, ob pump_id gleich 0 ist
        if job.pump_id == 0:
            print("pump_id ist 0.")
            pumpcontrol.cleanPumps(pump_runtime)  # Du kannst die Dauer der Reinigung hier nach Bedarf anpassen
               
        else:
            # Pumpe starten
            pumpcontrol.start_pumpfor(job.pump_id, pump_runtime)
        

        print("Maintenance Status aktualisiert")
        # Status des Wartungsjobs aktualisieren
        Maintenance.Database().updateStatus(job.id,2) 
