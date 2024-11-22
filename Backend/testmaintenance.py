import time
import pumpcontrol
from models import Maintenance

def checkForMaintainence():
    jobs = Maintenance.Database().selectByStatus(0)[0]
    for job in jobs:
        if job not in [None, []]:
            Maintenance.Database().updateStatus(job.id,1)
            pumpcontrol.start_pumpfor(job.pump_id, 10)
            time.sleep(5)
            Maintenance.Database().updateStatus(job.id,2) 
