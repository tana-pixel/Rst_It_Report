import sys
import requests
import time
from datetime import datetime

# จัดการเรื่อง Encoding สำหรับภาษาไทยบน Terminal
if hasattr(sys.stdout, "reconfigure"):
    sys.stdout.reconfigure(encoding="utf-8")
    sys.stderr.reconfigure(encoding="utf-8")

# CONFIG หลักของแผนก ASIA
ASIA_CONFIG = {
    "COM_CODE": "913560",
    "USER_ID": "ITASIA",
    "TEST_API_KEY": "07c59bf65c6de4f419ee63550b8d5e28a9", 
    "LAN_TYPE": "th-TH",
    "ZONE": "IA"
}

def get_test_session():
    login_url = f"https://sboapi{ASIA_CONFIG['ZONE'].lower()}.ecount.com/OAPI/V2/OAPILogin"
    login_payload = {
        "API_CERT_KEY": ASIA_CONFIG["TEST_API_KEY"].strip(),
        "COM_CODE": ASIA_CONFIG["COM_CODE"],
        "LAN_TYPE": ASIA_CONFIG["LAN_TYPE"],
        "USER_ID": ASIA_CONFIG["USER_ID"],
        "ZONE": ASIA_CONFIG["ZONE"].upper()
    }
    try:
        response = requests.post(login_url, json=login_payload, timeout=30)
        return response.json().get("Data", {}).get("Datas", {}).get("SESSION_ID")
    except Exception as e:
        print(f"❌ เกิดข้อผิดพลาดขณะเชื่อมต่อ Login: {str(e)}")
        return None

def run_inventory_activation():
    print(f"[{datetime.now().strftime('%H:%M:%S')}] ⚙️ เริ่มต้นโปรแกรมยิงปลดล็อกระบบรายงานสินค้าคงคลัง (สิทธิ์ 1 ปี)...")
    
    # 1. ดึงเซสชัน ID
    session_id = get_test_session()
    if not session_id:
        print("❌ ล็อกอินไม่สำเร็จ! กรุณาตรวจสอบการลงทะเบียน IP หรือ API KEY ของแผนก ASIA ครับ")
        return
        
    print(f"✅ เชื่อมต่อฐานข้อมูลทดสอบสำเร็จ (Session ID: {session_id})")

    # 2. ตั้งค่า Endpoint ตามคู่มือใหม่
    endpoint_path = "InventoryBalance/GetListInventoryBalanceStatus"
    menu_name = "สินค้าคงคลัง -> รายงานสถานะสินค้าคงคลัง"
    
    test_url = f"https://sboapi{ASIA_CONFIG['ZONE'].lower()}.ecount.com/OAPI/V2/{endpoint_path}?SESSION_ID={session_id}"
    today_str = datetime.now().strftime("%Y%m%d") # รูปแบบ ปปปปดดวว (YYYYMMDD) ตามที่คู่มือกำหนด
    
    # Payload รูปแบบเดียวกับ Example Parameter ในคู่มือเป๊ะๆ
    test_payload = {
        "PROD_CD": "",
        "WH_CD": "",
        "BASE_DATE": today_str
    }

    print(f"\n🚀 เริ่มส่งสัญญาณจำลองเพื่อปลดล็อกเมนู: [{menu_name}]")
    print("-" * 70)
    
    # ยิง Loop 3 รอบเพื่อบันทึก Log บน Sandbox ของ ECOUNT
    for count in range(1, 4):
        try:
            response = requests.post(test_url, json=test_payload, timeout=30)
            res_json = response.json()
            
            status_code = res_json.get("Status")
            if status_code == "200":
                print(f"⏳ [รอบที่ {count}/3] -> API: {endpoint_path} | Status: {status_code} ✅ ผ่าน (Success)")
            else:
                print(f"⏳ [รอบที่ {count}/3] -> API: {endpoint_path} | Status: {status_code} ⚠️ ตรวจสอบผลลัพธ์: {res_json.get('Error')}")
                
        except Exception as e:
            print(f"❌ รอบที่ {count} เกิดข้อผิดพลาดทางเทคนิค: {str(e)}")
            
        time.sleep(1.5) # หน่วงเวลาเล็กน้อยให้ระบบบันทึก Log ทัน

    print("\n==================================================")
    print("🎉 ยิงสัญญาณปลดล็อกเมนู [GetListInventoryBalanceStatus] ครบ 3 รอบแล้วครับ!")
    print("👉 ตอนนี้ให้พี่กลับไปหน้าเว็บ ECOUNT แล้วกด รีเฟรช (Refresh) ดูหน้าต่าง OAPI ได้เลยครับ!")
    print("==================================================")

if __name__ == "__main__":
    run_inventory_activation()