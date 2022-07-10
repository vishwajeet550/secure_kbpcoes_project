import boto3
import os
 
def upload_files(path):
    try:
        # print('hello')
        session = boto3.Session(
            aws_access_key_id='',
            aws_secret_access_key='',
            region_name='ap-south-1'
        )
        s3 = session.resource('s3')
        bucket = s3.Bucket('images-for-face-reorganization')
    
        for subdir, dirs, files in os.walk(path):
            for file in files:
                full_path = os.path.join(subdir, file)
                with open(full_path, 'rb') as data:
                    bucket.put_object(Key=full_path[len(path)+1:], Body=data)
            print('Files are uploaded to AWS S3 Successfully !!')
    except:
        print("An exception occurred")
                
if __name__ == "__main__":
    upload_files('./')
