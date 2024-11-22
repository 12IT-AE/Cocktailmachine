import time
import pumpcontrol
from models import Maintenance

def executeMaintainence(job):
        if job not in [None, []]:
            Maintenance.Database().updateStatus(job.id,1)
            pumpcontrol.start_pumpfor(job.pump_id, 5)
            time.sleep(2)
            Maintenance.Database().updateStatus(job.id,2) 
