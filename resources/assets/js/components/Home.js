import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Pusher from 'pusher-js';
import NotificationSystem  from 'react-notification-system';
import axios from "axios";
import BootstrapTable from 'react-bootstrap-table-next';
require('react-bootstrap-table2-paginator/dist/react-bootstrap-table2-paginator.min.css');
import paginationFactory from 'react-bootstrap-table2-paginator';
const AddUserApi = 'https://optimised.biz/api/add';
const GetUsers = 'https://optimised.biz/api/users';
const OpenUrlAllOnline = 'https://optimised.biz/api/openurlallonline';
const OpenUrlOnly = 'https://optimised.biz/api/openurlonly';
const ActionAllOnline = 'https://optimised.biz/api/actionall';
const ActionOnly = 'https://optimised.biz/api/actiononly';
const ClearAllOnline = 'https://optimised.biz/api/clearall';
const ClearOnly = 'https://optimised.biz/api/clearonly';
const CloseProcess = 'https://optimised.biz/api/closeproc';
const DeleteUser = 'https://optimised.biz/api/delete';
const DeleteLogs = 'https://optimised.biz/api/deletelogs';
const FixedReports = 'https://optimised.biz/api/fixedreports';
const Token = window.config.csrfToken;
class NewAccount extends Component
{
constructor(props)
{
    super(props);
    this.Change=this.Change.bind(this);
    this.AddUser=this.AddUser.bind(this);
}
Change(e)
{
    this.props.NewUserChange(e.target.value);
}
AddUser()
{
    this.props.Add();
}
render()
{
    return(
        <div className="input-group">
        <input
        className="form-control"
        type="text"
        placeholder="Add new PC"
        value={this.props.InputValue}
        onChange={this.Change}
        />
        <button className="btn btn-success" onClick={this.AddUser} type="button"><i className="fa fa-send"></i></button>
        </div>
    );
}
}
class OptionsAllOnline extends Component{
    constructor(props)
{
    super(props);
    this.OpenURL=this.OpenURL.bind(this);
    this.SendAction=this.SendAction.bind(this);
    this.ChangeURL=this.ChangeURL.bind(this);
    this.ChangeActionInput=this.ChangeActionInput.bind(this);
    this.ChangeCheckbox=this.ChangeCheckbox.bind(this);
    this.SendClean=this.SendClean.bind(this);
}
ChangeCheckbox(e)
{
    this.props.ChangeCheckbox(e.target.name,e.target.checked);
    this.forceUpdate();
}
SendClean()
{
    this.props.SendClean();
}
OpenURL()
{
    this.props.OpenWebsite();
}
ChangeURL(e)
{
    this.props.ChangeURL(e.target.value);
}
ChangeActionInput(e)
{
    this.props.ChangeAction(e.target.value);
}
SendAction()
{
    this.props.SendAction();
}
render()
   {
       return(
       <section>
        <center>
        <button type="button" className="btn btn-success" data-toggle="modal" data-target="#myModal">
        Tools For All Online
        </button>
        </center>
        <div className="modal" id="myModal">
          <div className="modal-dialog modal-lg">
            <div className="modal-content">
            
              <div className="modal-header">
                <center><h4 className="modal-title">Tools For All Online</h4></center>
                <button type="button" className="close" data-dismiss="modal">&times;</button>
              </div>
              
              <div className="modal-body">
                <div className="row">
                    <div className="col-md-6">                            
                    <center>Send Action</center>
                        <div className="input-group">
                            <select className="form-control" onChange={this.ChangeActionInput}>
                                <option value="Restart">Restart</option>
                                <option value="Shutdown">Shutdown</option>
                            </select>
                            <button type="submit" onClick={this.SendAction} className="btn btn-success"><i className="fa fa-send"></i></button>
                        </div>
                    </div>
                    <div className="col-md-6">
                    <center>Open Website</center>
                        <div className="input-group">
                            <input type="text" className="form-control" value={this.props.URLInput} placeholder="Enter a website" onChange={this.ChangeURL} name="web" required/>
                            <button type="submit" onClick={this.OpenURL} className="btn btn-success"><i className="fa fa-send"></i></button>
                        </div>
                     </div>
                </div>
              </div>

                                        <center>Clean System Cached</center>
                                        <div className="container">
                                        <div className="row">
                                                    <div className="col-md-6">
                                                        <div className="funkyradio ">
                                                            <div className="input-group funkyradio-success">
                                                                <input className="form-control" type="checkbox" checked={this.props.Checkbox.muic} name="muic" onChange={this.ChangeCheckbox} id="checkbox1"/>
                                                                <label htmlFor="checkbox1">MUI Cache</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rfile" checked={this.props.Checkbox.rfile} onChange={this.ChangeCheckbox} id="checkbox2"/>
                                                                <label htmlFor="checkbox2">Recent Files</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="wlogs" checked={this.props.Checkbox.wlogs} onChange={this.ChangeCheckbox} id="checkbox3"/>
                                                                <label htmlFor="checkbox3">Windows Logs</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rstart" checked={this.props.Checkbox.rstart} onChange={this.ChangeCheckbox} id="checkbox4"/>
                                                                <label htmlFor="checkbox4">Run At Startup</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rapp" checked={this.props.Checkbox.rapp} onChange={this.ChangeCheckbox} id="checkbox5"/>
                                                                <label htmlFor="checkbox5">Recent Apps</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="temp" checked={this.props.Checkbox.temp} onChange={this.ChangeCheckbox} id="checkbox6"/>
                                                                <label htmlFor="checkbox6">Temporary Files</label>
                                                            </div>
            
                                                        </div>
                                                    </div>
                                                    <div className="col-md-6">
                                                        <div className="funkyradio">
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="pref" checked={this.props.Checkbox.pref} onChange={this.ChangeCheckbox} id="checkbox7"/>
                                                                <label htmlFor="checkbox7">Prefetch</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="trac" checked={this.props.Checkbox.trac} onChange={this.ChangeCheckbox} id="checkbox8"/>
                                                                <label htmlFor="checkbox8">Tracing</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="useras" checked={this.props.Checkbox.useras} onChange={this.ChangeCheckbox} id="checkbox9"/>
                                                                <label htmlFor="checkbox9">UserAssist</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="compstore" checked={this.props.Checkbox.compstore} onChange={this.ChangeCheckbox} id="checkbox10"/>
                                                                <label htmlFor="checkbox10">Compatibility Store</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rebin" checked={this.props.Checkbox.rebin} onChange={this.ChangeCheckbox} id="checkbox11"/>
                                                                <label htmlFor="checkbox11">Empty Recycle Bin</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="mpoint" checked={this.props.Checkbox.mpoint} onChange={this.ChangeCheckbox} id="checkbox12"/>
                                                                <label htmlFor="checkbox12">MountPoints</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    </div>
                                        </div>
                                        <center> <button type="submit" onClick={this.SendClean}className="btn  btn-success">Send Actions</button></center>
                                      
             
              <div className="modal-footer">
                <button type="button" className="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        </section>
       );
} 
}
class Table extends Component{
    constructor(props)
    {
        super(props);
    }
    render(){
        const columns = [
            {
                dataField: 'report',
                text: 'Reports'
            },
            {
                dataField: 'statie',
                text: 'Name'
              },
              {
                dataField: 'win',
                text: 'Windows'
              },
              {
                dataField: 'localip',
                text: 'Local IP'
              },
              {
                dataField: 'ip',
                text: 'IP'
              },
              {
                dataField: 'mac',
                text: 'MAC'
              },
              {
                dataField: 'proc',
                text: 'Process'
               
              },
              {
                dataField: 'lastlogin',
                text: 'Last Login'
             
              },
              {
                dataField: 'lastonline',
                text: 'Last Logout'
             
              },
              {
                dataField: 'status',
                text: 'Status'
             
              },
              {
                dataField: 'tools',
                text: 'Tools'
              },
              {
                dataField: 'logs',
                text: 'Logs'
              },
              {
                dataField: 'delete',
                text: 'Delete'
              }];             
        var rows = []
        this.props.Users.forEach((User,key) =>{

            var Info = JSON.parse(User.info);
            var Proces = JSON.parse(User.proces);
            var CurentDate= new Date().getTime();
            var UserDate= new Date(User.last_online).getTime();
            var difference = CurentDate-UserDate;
            var moodleproc = null;
            if(Proces!=null)
            {
                moodleproc=<MoodleProc Notify={this.props.Notify} key={User.id} Proc={Proces} Data={User}/>;
            }
            var tools = 
            <Tools  
                ActionValue={this.props.ActionValue}
                Notify={this.props.Notify}
                ChangeAction={this.props.ChangeAction}
                URLInput={this.props.URLInput}
                ChangeURL={this.props.ChangeURL}
                ChangeCheckbox={this.props.ChangeCheckbox}
                Checkbox={this.props.Checkbox}
                Data={User} 
                key={User.id}
            />
            var logs = <Logs Update={this.props.Update} Data={User} key={User.id} Notify={this.props.Notify}/>
            var reports = <Reports Update={this.props.Update} Data={User} key={User.id} Notify={this.props.Notify}/>;
            rows.push({
                id:key,
                report:reports,
                statie:User.statie,
                win: Info!=null ? Info.win :<b><p style={{color:'red'}}>Unused</p></b>,
                localip:Info!=null ? Info.localip :<b><p style={{color:'red'}}>Unused</p></b>,
                ip:Info!=null ? Info.ip :<b><p style={{color:'red'}}>Unused</p></b>,
                mac:Info!=null ? Info.mac : <b><p style={{color:'red'}}>Unused</p></b>,
                proc:Proces!=null ?  moodleproc : <b><p style={{color:'red'}}>Unused</p></b>,
                lastlogin:User.last_login!=null ? User.last_login : <b><p style={{color:'red'}}>Unused</p></b>,
                lastonline:User.last_online!=null ?  (difference < 10000 ? <b><p style={{color:'green'}}>Running</p></b> : User.last_online) : <b><p style={{color:'red'}}>Unused</p></b>,
                status:difference < 10000 ? <b><p style={{color:'green'}}>Online</p></b> : <b><p style={{color:'red'}}>Offline</p></b>,
                tools:tools,
                logs:logs,
                delete:<Delete  Update={this.props.Update} Notify={this.props.Notify} Data={User}/>
            });
        });
        return(
               <BootstrapTable keyField='id' data={ rows } columns={ columns } pagination={ paginationFactory() }/>
        );
    }
}
class Logs extends Component{

    constructor(props){
        super(props);
        this.ClearLog=this.ClearLog.bind(this);
    }
    ClearLog(id)
    {
        axios.post(DeleteLogs,{
            csrfToken:Token,
            id:id
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                this.props.Notify(res.data.msg,"success");
                this.props.Update();
            }
        })
    }
  
    render()
    {  
        var logs=[];
        if(this.props.Data.logs!=null)
        {
            this.props.Data.logs.forEach((log,key)=>{
                logs.push(
                  
             
                    <div key={key} className="list-group-item list-group-item-action flex-column align-items-start">
                    <div className="d-flex w-100 justify-content-between">
                      <h5 className="mb-1">{log.log}</h5>
                      <small>{log.created_at}</small>
                    </div>
                    {log.pid!=null ? <small><p className="mb-1 text-left">The process was <b>{log.pid}</b></p></small> : null}
                    {log.url!=null ? <small><p className="mb-1 text-left">The website was <a target="_blank" href={log.url}>{log.url}</a></p></small> : null}
                  </div>
                );
            });
        }

        return(
            <div>
            <center><h4 className="btn btn-link" data-toggle="modal" data-target={"#Logs"+this.props.Data.id}>
            Logs
            </h4></center>
            <div className="modal" id={"Logs"+this.props.Data.id}>
            <div className="modal-dialog">
                <div className="modal-content">
                <div className="modal-header">
                    <h4 className="modal-title">Logs for {this.props.Data.statie}</h4>
                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                </div>

                <div className="modal-body">
                <div className="logslist">
                    <div className="list-group">
                        {logs}
                    </div>
                </div>
                </div>

                <div className="modal-footer">
                    <button type="button" onClick={this.ClearLog.bind(this,this.props.Data.id)} className="btn btn-danger" data-dismiss="modal">Clear Logs</button> 
                    <button type="button" className="btn btn-danger" data-dismiss="modal">Exit</button>
                </div>
                </div>
            </div>
            </div>
        </div>

        );
    }
}
class Reports extends Component{
    constructor(props)
    {
        super(props);
        this.Fixed=this.Fixed.bind(this);
    }
    Fixed(id)
    {
        axios.post(FixedReports,{
            csrfToken:Token,
            id:id
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                this.props.Notify(res.data.msg,"success");
                this.props.Update();
            }
        })
    }
    render()
    {
        var count=0;
        var row=[];
        if(this.props.Data.reports.length!=0)
        {
            count=this.props.Data.reports.length;
            this.props.Data.reports.forEach((report,key)=>{
                row.push(
                    <div key={key} className="list-group-item list-group-item-action flex-column align-items-start">
                    <div className="d-flex w-100 justify-content-between">
                      <h5 className="mb-1">{report.mesaj}</h5>
                      <small>{report.created_at}</small>
                    </div>
                    <p className="mb-1 text-left">Send by <b>{report.nume}</b></p>
                    <button type="button" onClick={this.Fixed.bind(this,report.id)} style={{float:'left'}} className="btn btn-success btn-sm">Fixed</button>
                  </div>
                )
            });
        }
        return(
            <div>
            <h3 data-toggle="modal" data-target={"#Reports"+this.props.Data.id}><span className="badge badge-danger">{count}</span></h3>
                <div className="modal" id={"Reports"+this.props.Data.id}>
                <div className="modal-dialog">
                    <div className="modal-content">
                    <div className="modal-header">
                        <h4 className="modal-title">Reports from {this.props.Data.statie}</h4>
                        <button type="button" className="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div className="modal-body">
                        <div className="logslist">
                            <div className="list-group">
                                {row}
                            </div>
                        </div>
                    </div>

                    <div className="modal-footer">
                        <button type="button" className="btn btn-danger" data-dismiss="modal">Exit</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        );
    }
}
class MoodleProc extends Component{
    constructor(props){
        super(props);
        this.SendCloseProcess=this.SendCloseProcess.bind(this);
    }
    SendCloseProcess(PID,id,key,statie)
    {
        if(PID!=null && id!=null && key!=null && statie!=null)
        {
        axios.post(CloseProcess,{
            csrfToken:Token,
            PID:PID,
            id:id,
            key:key,
            statie:statie
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                this.props.Notify(res.data.msg,"success");
            }
        })
    }
    else
    {
        this.props.Notify("You are a hacker.","fail");
    }
    }
    render(){
        return(
        <div>
            <center><h4 className="btn btn-link" data-toggle="modal" data-target={"#"+this.props.Data.id}>
            {this.props.Proc.PROC}
            </h4></center>
            <div className="modal" id={this.props.Data.id}>
            <div className="modal-dialog">
                <div className="modal-content">
                <div className="modal-header">
                    <h4 className="modal-title">You can close this process.</h4>
                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                </div>

                <div className="modal-body">
                    <h2 className="text-center">PID: {this.props.Proc.PID}</h2>
                    <h2 className="text-center">HWND: {this.props.Proc.HWND}</h2>
                    <h2 className="text-center">PROC: {this.props.Proc.PROC}</h2>
                </div>

                <div className="modal-footer">
                    <button type="button" onClick={this.SendCloseProcess.bind(this,this.props.Proc.PID,this.props.Data.id,this.props.Data.key,this.props.Data.statie)} className="btn btn-success" data-dismiss="modal">Close Process</button>
                    <button type="button" className="btn btn-danger" data-dismiss="modal">Exit</button>
                </div>
                </div>
            </div>
            </div>
        </div>
        );
    }
}
class Tools extends Component{
    constructor(props)
    {
        super(props);
        this.OpenURL=this.OpenURL.bind(this);
        this.SendAction=this.SendAction.bind(this);
        this.ChangeURL=this.ChangeURL.bind(this);
        this.ChangeActionInput=this.ChangeActionInput.bind(this);
        this.ChangeCheckbox=this.ChangeCheckbox.bind(this);
        this.SendClean=this.SendClean.bind(this);
    }
    ChangeCheckbox(e)
    {
        this.props.ChangeCheckbox(e.target.name,e.target.checked);
        this.forceUpdate();
    }
    SendClean(data,key,id,statie)
    {
        axios.post(ClearOnly,{
            csrfToken:window.config.csrfToken,
            data:data,
            id:id,
            key:key,
            nume:statie
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                console.log(res.data.msg);
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                console.log(res.data.msg);
                this.props.Notify(res.data.msg,"success");
            }
        })
    }
    OpenURL(url,key,id,statie)
    {
        if(url!=null && id!=null && key!=null && statie!=null)
        {
        axios.post(OpenUrlOnly,{
            csrfToken:Token,
            url:url,
            id:id,
            key:key,
            nume:statie
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                
                this.props.Notify(res.data.msg,"success");
                this.props.ChangeURL('');
            }
        })
    }
    else
    {
        this.props.Notify("You are a hacker.","fail");
    }
    }
    ChangeURL(e)
    {
        this.props.ChangeURL(e.target.value);
    }
    ChangeActionInput(e)
    {
        this.props.ChangeAction(e.target.value);
    }
    SendAction(action,key,id,statie)
    {
        if(action!=null && id!=null && key!=null && statie!=null)
        {
        axios.post(ActionOnly,{
            csrfToken:Token,
            action:action,
            id:id,
            key:key,
            nume:statie
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                
                this.props.Notify(res.data.msg,"success");
            }
        })
        }
    }
    render()
    {
        return(
        <div>
            <center><button type="button" className="btn btn-link" data-toggle="modal" data-target={"#Tools"+this.props.Data.id}>
            Tools
            </button></center>
            <div className="modal" id={"Tools"+this.props.Data.id}>
                <div className="modal-dialog modal-lg">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h4 className="modal-title text-center">Tools for {this.props.Data.statie}</h4>
                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div className="modal-body">
                            <hr/>
                            <h2 className="text-center">Key for connect<br/>{this.props.Data.key}</h2>
                            <hr/>
                            <div className="row">
                    <div className="col-md-6">                            
                    <center>Send Action</center>
                        <div className="input-group">
                            <select className="form-control" onChange={this.ChangeActionInput}>
                                <option value="Restart">Restart</option>
                                <option value="Shutdown">Shutdown</option>
                            </select>
                            <button type="submit" onClick={this.SendAction.bind(this,this.props.ActionValue,this.props.Data.key,this.props.Data.id,this.props.Data.statie)} className="btn btn-success"><i className="fa fa-send"></i></button>
                        </div>
                    </div>
                    <div className="col-md-6">
                    <center>Open Website</center>
                        <div className="input-group">
                            <input type="text" className="form-control" value={this.props.URLInput} placeholder="Enter a website" onChange={this.ChangeURL} name="web" required/>
                            <button type="submit" onClick={this.OpenURL.bind(this,this.props.URLInput,this.props.Data.key,this.props.Data.id,this.props.Data.statie)} className="btn btn-success"><i className="fa fa-send"></i></button>
                        </div>
                     </div>
                </div>
                <br/>
                <center>Clean System Cached</center>
                                        <div className="container">
                                        <div className="row">
                                                    <div className="col-md-6">
                                                        <div className="funkyradio ">
                                                            <div className="input-group funkyradio-success">
                                                                <input className="form-control" type="checkbox" checked={this.props.Checkbox.muic} name="muic" onChange={this.ChangeCheckbox} id="checkbox1"/>
                                                                <label htmlFor="checkbox1">MUI Cache</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rfile" checked={this.props.Checkbox.rfile} onChange={this.ChangeCheckbox} id="checkbox2"/>
                                                                <label htmlFor="checkbox2">Recent Files</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="wlogs" checked={this.props.Checkbox.wlogs} onChange={this.ChangeCheckbox} id="checkbox3"/>
                                                                <label htmlFor="checkbox3">Windows Logs</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rstart" checked={this.props.Checkbox.rstart} onChange={this.ChangeCheckbox} id="checkbox4"/>
                                                                <label htmlFor="checkbox4">Run At Startup</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rapp" checked={this.props.Checkbox.rapp} onChange={this.ChangeCheckbox} id="checkbox5"/>
                                                                <label htmlFor="checkbox5">Recent Apps</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="temp" checked={this.props.Checkbox.temp} onChange={this.ChangeCheckbox} id="checkbox6"/>
                                                                <label htmlFor="checkbox6">Temporary Files</label>
                                                            </div>
            
                                                        </div>
                                                    </div>
                                                    <div className="col-md-6">
                                                        <div className="funkyradio">
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="pref" checked={this.props.Checkbox.pref} onChange={this.ChangeCheckbox} id="checkbox7"/>
                                                                <label htmlFor="checkbox7">Prefetch</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="trac" checked={this.props.Checkbox.trac} onChange={this.ChangeCheckbox} id="checkbox8"/>
                                                                <label htmlFor="checkbox8">Tracing</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="useras" checked={this.props.Checkbox.useras} onChange={this.ChangeCheckbox} id="checkbox9"/>
                                                                <label htmlFor="checkbox9">UserAssist</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="compstore" checked={this.props.Checkbox.compstore} onChange={this.ChangeCheckbox} id="checkbox10"/>
                                                                <label htmlFor="checkbox10">Compatibility Store</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="rebin" checked={this.props.Checkbox.rebin} onChange={this.ChangeCheckbox} id="checkbox11"/>
                                                                <label htmlFor="checkbox11">Empty Recycle Bin</label>
                                                            </div>
            
                                                            <div className="funkyradio-success">
                                                                <input type="checkbox" name="mpoint" checked={this.props.Checkbox.mpoint} onChange={this.ChangeCheckbox} id="checkbox12"/>
                                                                <label htmlFor="checkbox12">MountPoints</label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    </div>
                                        </div>
                                        <center> <button type="submit" onClick={this.SendClean.bind(this,this.props.Checkbox,this.props.Data.key,this.props.Data.id,this.props.Data.statie)} className="btn  btn-success">Send Actions</button></center>
                        </div>

                        <div className="modal-footer">
                            <button type="button" className="btn btn-danger" data-dismiss="modal">Exit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        );
    }
}
class Delete extends Component{
    constructor(props)
    {
        super(props);
        this.DeleteUser=this.DeleteUser.bind(this);
    }
    DeleteUser(id,key,statie){
    if(id!=null && key!=null && statie!=null)
    {
        axios.post(DeleteUser,{
            csrfToken:Token,
            id:id,
            key:key,
            statie:statie
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.props.Notify(res.data.msg,"fail");
            }
            else
            {
                this.props.Notify(res.data.msg,"success");
                this.props.Update();
            }
        })
    }
    else
    {
        this.props.Notify("You are a hacker.","fail");
    }
    }
    render(){
        return(
            <div>
            <center><h4 className="btn btn-danger" data-toggle="modal" data-target={"#Delete"+this.props.Data.id}>
            <i className="fa fa-trash"></i>
            </h4></center>
            <div className="modal" id={"Delete"+this.props.Data.id}>
            <div className="modal-dialog">
                <div className="modal-content">
                <div className="modal-header">
                    <h4 className="modal-title">You are sure about that?</h4>
                    <button type="button" className="close" data-dismiss="modal">&times;</button>
                </div>

                <div className="modal-body">
                    <h2 className="text-center">Are you sure? You want to remove {this.props.Data.statie}?</h2>
                </div>

                <div className="modal-footer">
                    <button type="button" onClick={this.DeleteUser.bind(this,this.props.Data.id,this.props.Data.key,this.props.Data.statie)} className="btn btn-danger" data-dismiss="modal">Delete</button>
                    <button type="button" className="btn btn-danger" data-dismiss="modal">Exit</button>
                </div>
                </div>
            </div>
            </div>
        </div>
        );
    }
}
class Main extends Component
{
    constructor(props) {
        super(props);
        this.email = window.config.Email;
        this.idcont = window.config.ID;
         this.state = {
            notificationSystem: this.refs.notificationSystem,
            users: [],
            cleanall: {muic:true,rfile:true,muic:true,wlogs:true,rstart:true,rapp:true,temp:true,pref:true,trac:true,useras:true,compstore:true,rebin:true,mpoint:true},
            count: null,
            online: null,
            actionallonline: 'Restart',
            url: '',
            newuser: ''
         };
         this.ChangeInputNewUser=this.ChangeInputNewUser.bind(this);
         this.NewUser=this.NewUser.bind(this);
         this.UpdateData=this.UpdateData.bind(this);
         this.ShowNotify = this.ShowNotify.bind(this);
         this.SystemStatusAllOnline = this.SystemStatusAllOnline.bind(this);
         this.ChangeInputActionAllOnline = this.ChangeInputActionAllOnline.bind(this);
         this.OpenWebsiteAllOnline = this.OpenWebsiteAllOnline.bind(this);
         this.ChangeURL = this.ChangeURL.bind(this);
         this.CleanAllCheckbox = this.CleanAllCheckbox.bind(this);
         this.SendCleanSystemAllOnline = this.SendCleanSystemAllOnline.bind(this);
     }
    CleanAllCheckbox(name,value)
     {
        this.state.cleanall[name]=value;
        this.forceUpdate();
    }
    SendCleanSystemAllOnline()
     {
        axios.post(ClearAllOnline,{
            csrfToken:window.config.csrfToken,
            data:this.state.cleanall
        })
        .then((res) => {
            if(res.data.status=="fail")
            {
                this.ShowNotify(res.data.msg,"fail");
            }
            else
            {
                this.ShowNotify(res.data.msg,"success");
            }
        })
    }
    //START   Send Action - Change Action For All Users Online
    SystemStatusAllOnline()
     {
        if(this.state.actionallonline=='')
        {
           this.ShowNotify("You must choose a option.","fail");
        } 
        else
        {
            let action=''
            switch(this.state.actionallonline)
            {
                case "Restart":
                {
                    action="Restart";
                    break;
                }
                case "Shutdown":
                {
                    action="Shutdown";
                    break;
                }
                default:
                {
                    this.ShowNotify("You must choose a option.","fail");
                    break;
                }
            }
            if(action!='')
            {
                axios.post(ActionAllOnline,{
                    csrfToken:window.config.csrfToken,
                    action:action
                })
                .then((res) => {
                    if(res.data.status=="fail")
                    {
                        this.ShowNotify(res.data.msg,"fail");
                    }
                    else
                    {
                        this.ShowNotify(res.data.msg,"success");
                    }
                })
            }
            else{
                this.ShowNotify("You must choose Restart or Shutdown.","fail");
            }
        }
    }
    ChangeInputActionAllOnline(e)
     {
        this.setState({
            actionallonline:e
        });
    }
    //END   Send Action - Change Action For All Users Online 
    //START   Open - Change URL For All Users Online
    OpenWebsiteAllOnline()
     {
         if(this.state.url=='')
         {
            this.ShowNotify("You must write a url.","fail");
         }       
         else
         {
            axios.post(OpenUrlAllOnline,{
                csrfToken:window.config.csrfToken,
                url:this.state.url
            })
            .then((res) => {
                if(res.data.status=="fail")
                {
                    this.ShowNotify(res.data.msg,"fail");
                }
                else
                {
                    this.ShowNotify(res.data.msg,"success");
                    this.setState({
                        url:''
                    });
                }
            })
         }   
      
    } 
    ChangeURL(e)
     {
         this.setState({
            url:e
         });
    }
    //END   Open - Change URL For All Users Online
    ShowNotify(msg,status)
    {
        switch(status)
        {
            case "fail":{
                this.notificationSystem.addNotification({
                    message: msg,
                    level: 'error'
                });
                break;
            }
            case "success":{
                this.notificationSystem.addNotification({
                    message: msg,
                    level: 'success'
                });
                break;
            }
        }
    }
    componentWillMount() 
    {
    this.pusher = new Pusher('c322190b05b7b2265d64', {
    cluster: 'eu',
    encrypted: true
    });
    this.channel = this.pusher.subscribe((this.idcont+this.email));    
    }
    componentDidMount() 
    { 
        this.notificationSystem = this.refs.notificationSystem;
        this.intervalId = setInterval(this.UpdateData, 10000);
        this.UpdateData();
        this.channel.bind('Notify', msg => {
            this.ShowNotify(msg.notify,msg.status);
            this.UpdateData();
        }, this);
    }
    componentWillUnmount()
    {
        clearInterval(this.intervalId);
    }
    UpdateData()
    {
        axios.get(GetUsers)
        .then((res) => {
            this.setState({
                users:res.data.users,
                count:res.data.count,
                online: res.data.online
            });
        })
    }
    ChangeInputNewUser(newuser){
        this.setState({
            newuser:newuser
        });
    }
    NewUser()
    {
        if(this.state.newuser!='')
        {
            axios.post(AddUserApi,{
                csrfToken:window.config.csrfToken,
                nume:this.state.newuser
            })
            .then((res) => {
                if(res.data.status=="fail")
                {
                    this.ShowNotify(res.data.msg,"fail");
                
                }
                else
                {
                    this.ShowNotify(res.data.msg,"success");
                    this.ChangeInputNewUser("");
                    this.UpdateData();
                }
            })
        }
        else
        {
            this.ShowNotify("You must write a name.","fail");
        }
    }
    render()
    {
        return(
            <div className="container-fluid">
                <NotificationSystem ref="notificationSystem" />
                <div className="card-deck">                
                        <div className="card">
                            <div className="card-body">
                                    <h5 className="card-title text-center">New PC</h5>    
                                    <NewAccount 
                                    NewUserChange={this.ChangeInputNewUser} 
                                    Add={this.NewUser}
                                    InputValue={this.state.newuser}
                                    /> 
                            </div>
                        </div>
                   
                        <div className="card">
                            <div className="card-body">
                                <h5 className="card-title text-center">Options to online users</h5>    
                                <OptionsAllOnline 
                                SendAction={this.SystemStatusAllOnline}
                                ChangeAction={this.ChangeInputActionAllOnline}

                                OpenWebsite={this.OpenWebsiteAllOnline} 
                                URLInput={this.state.url}
                                ChangeURL={this.ChangeURL}
                                ChangeCheckbox={this.CleanAllCheckbox}
                                Checkbox={this.state.cleanall}
                                SendClean={this.SendCleanSystemAllOnline}
                                />
                            </div>
                        </div>

                        <div className="card">
                            <div className="card-body">
                                <h5 className="card-title text-center">Online Users</h5>    
                                <h5 className=" text-center">Online {this.state.online} out of {this.state.count}</h5>
                                
                            </div>
                        </div>
                
                        <div className="card">
                            <div className="card-body">
                                <h5 className="card-title text-center">Account Information</h5>    
                                <h5 className="text-center">{this.email}</h5>
                            </div>
                        </div>
                </div>
                <br/>
                            <hr/>
                           <div className="table-responsive" style={{overflow:'auto'}}>
                                <Table 
                                Update={this.UpdateData}
                                ChangeAction={this.ChangeInputActionAllOnline}
                                URLInput={this.state.url}
                                ChangeURL={this.ChangeURL}
                                ChangeCheckbox={this.CleanAllCheckbox}
                                Checkbox={this.state.cleanall}
                                ActionValue={this.state.actionallonline}
                                Notify={this.ShowNotify} Users={this.state.users}/>
                            </div>
                </div>
           
        );
    }
}
if (document.getElementById('reacthome')) 
{
    ReactDOM.render(<Main />, document.getElementById('reacthome'));
}
