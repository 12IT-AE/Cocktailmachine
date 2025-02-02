import pumpcontrol,main
from models import Maintenance,Pump


from logging_config import Logger

logger_singleton = Logger()
logger = logger_singleton.get_logger(__name__)

def executeMaintainence(job,pump_runtime=2):
        if job is None:
            logger.warning("Kein Wartungsjob übergeben. Abbruch.")
            return
        
        # Überprüfen, ob pump_id gleich 0 ist
        if job.pump_id == 0:
            pumpcontrol.cleanPumps(pump_runtime)  # Du kannst die Dauer der Reinigung hier nach Bedarf anpassen
        
        # Überprüfen, ob pump_id gleich 66 ist
        elif job.pump_id == -66:
            logger.info("stop running")
            main.running=False

        else:
            # Pumpe starten
            pump = Pump.Database().selectByID(job.pump_id)
            if not pump:
                logger.error(f"Pumpe mit ID {job.pump_id} nicht gefunden!")
                Maintenance.Database().updateStatus(job.id,4)
                return
            pumpcontrol.start_pumpfor(pump.pin, pump_runtime)
        

        logger.debug("Maintenance Status aktualisiert")
        # Status des Wartungsjobs aktualisieren
        Maintenance.Database().updateStatus(job.id,2) 

