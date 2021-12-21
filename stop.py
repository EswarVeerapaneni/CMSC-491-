import boto3
import time


def stop_model(model_arn):

    client=boto3.client('rekognition')

    print('Stopping model:' + model_arn)

    #Stop the model
    try:
        response=client.stop_project_version(ProjectVersionArn=model_arn)
        status=response['Status']
        print ('Status: ' + status)
    except Exception as e:  
        print(e)  

    print('Done...')
    
def main():
    
    model_arn='arn:aws:rekognition:us-east-2:191261383508:project/Test/version/Test.2021-12-20T12.10.03/1640020204092'
    stop_model(model_arn)

if __name__ == "__main__":
    main() 
