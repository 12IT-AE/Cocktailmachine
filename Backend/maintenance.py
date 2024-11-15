import time
def checkForMaintainence(DB):
    jobs = DB.select("maintenance", condition="status = 0")
    if len(jobs) == 0:
        return
    for job in jobs:
        print(f"Reinige Pumpe {job[1]}")
        DB.update("maintenance", {"status": 1}, f"id = {job[0]}")

    time.sleep(5)
    DB.update("maintenance", {"status": 2}, f"id = {job[0]}")
