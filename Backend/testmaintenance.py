import time
from models import Maintenance
def checkForMaintainence(DB):
    job = Maintenance.Database().selectFirstByStatus(0)
    if job not in [None, []]:
        Maintenance.Database().updateStatus(job.id,1)
        #DB.update("maintenance", {"status": 1}, f"id = {job[0]}")

    time.sleep(5)
    Maintenance.Database().updateStatus(job.id,2)
    #DB.update("maintenance", {"status": 2}, f"id = {job[0]}")
