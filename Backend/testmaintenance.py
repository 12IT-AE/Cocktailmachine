import time
import pumps
from models import Maintenance

def checkForMaintainence():
    job = Maintenance.Database().selectFirstByStatus(0)
    if job not in [None, []]:
        Maintenance.Database().updateStatus(job.id,1)
        pumps.cleanPumps(10)
        time.sleep(5)
        Maintenance.Database().updateStatus(job.id,2) 
