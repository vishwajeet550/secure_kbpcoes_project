import boto3
import logging

session = boto3.Session( 
         aws_access_key_id='', 
         aws_secret_access_key='')

# Then use the session to get the resource
s3 = session.resource('s3')
my_bucket = s3.Bucket('test-images-v')

# Get the data from S3
s3_client = boto3.client('s3', 
            aws_access_key_id='',
            aws_secret_access_key='',
            region_name='ap-south-1')

for my_bucket_object in my_bucket.objects.all():
    print(my_bucket_object.key)
    try:
        s3_client.download_file('test-images-v', my_bucket_object.key, my_bucket_object.key)
        print('success')
    except:
        logging.warning("error occurs")
        raise
        
