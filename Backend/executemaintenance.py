import time
import pumpcontrol
from models import Maintenance

def executeMaintainence(job,pump_runtime=5):
        if job is None:
            print("Kein Wartungsjob übergeben. Abbruch.")
            return
        # Pumpe starten
        pumpcontrol.start_pumpfor(job.pump_id, pump_runtime)
        
        # Warten bis die Pumpe fertig ist
        time.sleep(pump_runtime)  
        
        # Status des Wartungsjobs aktualisieren
        Maintenance.Database().updateStatus(job.id,2) 
